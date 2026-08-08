Новое сообщение с формы контактов

Имя: {{ $contactMessage->name }}
Email: {{ $contactMessage->email }}
IP: {{ $contactMessage->ip ?: '—' }}

Сообщение:
{{ $contactMessage->message }}
