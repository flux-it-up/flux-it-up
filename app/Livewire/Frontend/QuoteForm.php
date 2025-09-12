<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Quote;
use App\Mail\QuoteSubmitted;
use Illuminate\Support\Facades\Mail;
use App\Livewire\Traits\Alert;

class QuoteForm extends Component
{
    use Alert;

    public $name, $email, $console_type, $issue;

    public $showModal = false;

    protected $listeners = ['open-quote-modal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'console_type' => 'required|string|max:255',
        'issue' => 'required|string|max:500',
    ];

    public function submit()
    {
        $this->validate();

        $quote = Quote::create([
            'name' => $this->name,
            'email' => $this->email,
            'console_type' => $this->console_type,
            'issue' => $this->issue,
        ]);

        // Send email to admin (set in .env MAIL_FROM_ADDRESS / MAIL_TO)
        Mail::to(config('mail.from.address'))->send(new QuoteSubmitted($quote));
        
        // Clear form
        $this->reset(['name', 'email', 'console_type', 'issue']);
        
        $this->modal = false;
        $this->toast()->success('Quote request submitted successfully!')->send();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.frontend.quote-form');
    }
}
