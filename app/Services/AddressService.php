<?php

namespace App\Services;

use InvalidArgumentException;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AddressService
{
    /**
     * Set an existing address as the default shipping address
     */
    public function setDefaultShippingAddress(User $user, Address $address): Address
    {
        $this->validateAddressOwnership($user, $address);
        $this->validateAddressType($address, 'shipping');

        return DB::transaction(function () use ($user, $address) {
            $this->clearDefaultAddresses($user, 'shipping', $address->id);
            $address->update(['is_default' => true]);
            $this->clearUserRelationCache($user, 'defaultShippingAddress');
            
            return $address->fresh();
        });
    }

    /**
     * Set an existing address as the default billing address
     */
    public function setDefaultBillingAddress(User $user, Address $address): Address
    {
        $this->validateAddressOwnership($user, $address);
        $this->validateAddressType($address, 'billing');

        return DB::transaction(function () use ($user, $address) {
            $this->clearDefaultAddresses($user, 'billing', $address->id);
            $address->update(['is_default' => true]);
            $this->clearUserRelationCache($user, 'defaultBillingAddress');
            
            return $address->fresh();
        });
    }

    /**
     * Create a new address for the user
     */
    public function createAddress(
        User $user, 
        array $addressData, 
        string $type = 'shipping', 
        bool $isDefault = false
    ): Address|Collection {
        $this->validateAddressType($type);

        return DB::transaction(function () use ($user, $addressData, $type, $isDefault) {
            if ($type === 'both') {
                return $this->createBothAddresses($user, $addressData, $isDefault);
            }

            return $this->createSingleAddress($user, $addressData, $type, $isDefault);
        });
    }

    /**
     * Create a shipping address
     */
    public function createShippingAddress(User $user, array $addressData, bool $isDefault = false): Address
    {
        return $this->createSingleAddress($user, $addressData, 'shipping', $isDefault);
    }

    /**
     * Create a billing address
     */
    public function createBillingAddress(User $user, array $addressData, bool $isDefault = false): Address
    {
        return $this->createSingleAddress($user, $addressData, 'billing', $isDefault);
    }

    /**
     * Delete an address (soft delete)
     */
    public function deleteAddress(User $user, Address $address): bool
    {
        $this->validateAddressOwnership($user, $address);

        return DB::transaction(function () use ($user, $address) {
            $wasDefault = $address->is_default;
            $type = $address->type;
            
            $deleted = $address->delete();
            
            // If this was the default address, set another one as default
            if ($wasDefault && $deleted) {
                $this->setNextAddressAsDefault($user, $type);
            }
            
            return $deleted;
        });
    }

    /**
     * Update an existing address
     */
    public function updateAddress(User $user, Address $address, array $addressData, bool $isDefault = false): Address
    {
        // Validate ownership
        if ($address->user_id !== $user->id) {
            throw new InvalidArgumentException('Address does not belong to this user.');
        }

        // Handle default status
        if ($isDefault && !$address->is_default) {
            // Clear other default addresses of the same type
            $user->addresses()
                ->where('type', $addressData['type'])
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        // Update the address
        $address->update(array_merge(
            $addressData,
            ['is_default' => $isDefault]
        ));

        return $address->fresh();
    }

    // ==================== Private Helper Methods ====================

    /**
     * Create a single address
     */
    private function createSingleAddress(User $user, array $addressData, string $type, bool $isDefault): Address
    {
        $addressData = $this->prepareAddressData($addressData, $type, $isDefault);

        if ($isDefault) {
            $this->clearDefaultAddresses($user, $type);
        }

        $address = $user->addresses()->create($addressData);
        
        if ($isDefault) {
            $this->clearUserRelationCache($user, "default{$this->getCapitalizedType($type)}Address");
        }

        return $address;
    }

    /**
     * Create both shipping and billing addresses
     */
    private function createBothAddresses(User $user, array $addressData, bool $isDefault)
    {
        $addresses = collect();

        // Create shipping address
        $shippingData = $this->prepareAddressData($addressData, 'shipping', $isDefault);
        if ($isDefault) {
            $this->clearDefaultAddresses($user, 'shipping');
        }
        $addresses->put('shipping', $user->addresses()->create($shippingData));

        // Create billing address
        $billingData = $this->prepareAddressData($addressData, 'billing', $isDefault);
        if ($isDefault) {
            $this->clearDefaultAddresses($user, 'billing');
        }
        $addresses->put('billing', $user->addresses()->create($billingData));

        if ($isDefault) {
            $this->clearUserRelationCache($user, 'defaultShippingAddress');
            $this->clearUserRelationCache($user, 'defaultBillingAddress');
        }

        return $addresses;
    }

    /**
     * Prepare address data with type and default status
     */
    private function prepareAddressData(array $addressData, string $type, bool $isDefault): array
    {
        return array_merge($addressData, [
            'type' => $type,
            'is_default' => $isDefault,
        ]);
    }

    /**
     * Clear default status from other addresses of the same type
     */
    private function clearDefaultAddresses(User $user, string $type, ?int $excludeId = null): void
    {
        $query = $user->addresses()->where('type', $type);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $query->update(['is_default' => false]);
    }

    /**
     * Set the next available address as default when the current default is deleted
     */
    private function setNextAddressAsDefault(User $user, string $type): void
    {
        $nextAddress = $user->addresses()
            ->where('type', $type)
            ->where('is_default', false)
            ->first();

        if ($nextAddress) {
            $nextAddress->update(['is_default' => true]);
        }
    }

    /**
     * Clear user relationship cache
     */
    private function clearUserRelationCache(User $user, string $relation): void
    {
        if ($user->relationLoaded($relation)) {
            $user->unsetRelation($relation);
        }
    }

    /**
     * Validate that the address belongs to the user
     */
    private function validateAddressOwnership(User $user, Address $address): void
    {
        if ($address->user_id !== $user->id) {
            throw new InvalidArgumentException('Address does not belong to this user.');
        }
    }

    /**
     * Validate address type for existing addresses
     */
    private function validateAddressType(Address|string $address, ?string $expectedType = null): void
    {
        if ($address instanceof Address) {
            $type = $address->type;
        } else {
            $type = $address;
        }

        $validTypes = ['shipping', 'billing', 'both'];
        
        if (!in_array($type, $validTypes)) {
            throw new InvalidArgumentException("Invalid address type. Must be one of: " . implode(', ', $validTypes));
        }

        if ($expectedType && $type !== $expectedType) {
            throw new InvalidArgumentException("Address must be a {$expectedType} address.");
        }
    }

    /**
     * Get capitalized type for method names
     */
    private function getCapitalizedType(string $type): string
    {
        return ucfirst($type);
    }
}
