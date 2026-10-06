<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Registration.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';
require_once __DIR__ . '/../core/Security.php';

class RegistrationController
{
    private Registration $registration;

    public function __construct()
    {
        $this->registration = new Registration();
    }

    public function create(): void
    {
        require __DIR__ . '/../views/registration/create.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('registration', 'create');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('registration', 'create');
        }

        $full_name      = Security::stripEmoji(trim((string)($_POST['full_name']       ?? '')));
        $contact_number_raw = trim((string)($_POST['contact_number'] ?? ''));
        $email          = trim((string)($_POST['email']           ?? ''));
        $address        = Security::stripEmoji(trim((string)($_POST['address']         ?? '')));
        $password       =              ($_POST['password']        ?? '');
        $confirm        =              ($_POST['password_confirm'] ?? '');

        $hasError = false;
        $contact_number = '';

        // Normalize and validate PH phone number
        if ($contact_number_raw !== '') {
            $normalized = Security::validatePHPhone($contact_number_raw);
            if ($normalized === false) {
                Flash::set('error', 'Invalid contact number. Please enter a valid Philippine mobile number (e.g. 09171234567 or +639171234567).');
                $hasError = true;
            } else {
                $contact_number = $normalized;
            }
        } else {
            Flash::set('error', 'Contact number is required.');
            $hasError = true;
        }

        if ($full_name === '') {
            Flash::set('error', 'Full name is required.');
            $hasError = true;
        } elseif (!Security::validateName($full_name)) {
            Flash::set('error', 'Full name contains invalid characters. Only letters, spaces, hyphens, and apostrophes are allowed.');
            $hasError = true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flash::set('error', 'A valid email address is required.');
            $hasError = true;
        }
        if ($address !== '' && !Security::validateAddress($address)) {
            Flash::set('error', 'Address contains invalid characters. Only letters, digits, spaces, and common punctuation (,.#-/()) are allowed.');
            $hasError = true;
        }        if (strlen($password) < 6) {
            Flash::set('error', 'Password must be at least 6 characters.');
            $hasError = true;
        }
        if ($password !== $confirm) {
            Flash::set('error', 'Passwords do not match.');
            $hasError = true;
        }
        if (!$hasError && $this->registration->findByEmail($email)) {
            Flash::set('error', 'That email is already registered.');
            $hasError = true;
        }

        if ($hasError) {
            redirect('registration', 'create');
        }

        $this->registration->create(
            $full_name,
            $contact_number,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            0,
            $address
        );

        Flash::set('success', 'Account created! You can now log in.');
        redirect('auth', 'index');
    }
}
