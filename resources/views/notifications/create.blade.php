@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📝 Schedule a New Notification</h2>

    <form action="{{ route('notifications.store') }}" method="POST">
                @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @csrf
        <div class="mb-3">
            <label for="title">Title</label>
            <input name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>



        <div class="form-group">
            <label for="notification_type">Notification Type</label>
            <select name="notification_type" id="notification_type" class="form-control" required>
                <option value="mail">Email</option>
                <option value="sms">SMS</option>
                <option value="push">Push Notification</option>
            </select>
        </div>

        <div class="form-group mt-2" id="recipient-wrapper">
            <label for="recipient" id="recipient-label">recipient Email</label>
            <input type="text" name="recipient" id="recipient" class="form-control" required>
        </div>

        <script>
            const typeSelect = document.getElementById('notification_type');
            const recipientWrapper = document.getElementById('recipient-wrapper');
            const recipientLabel = document.getElementById('recipient-label');
            const recipientInput = document.getElementById('recipient');

            typeSelect.addEventListener('change', function () {
                const type = this.value;
                if (type === 'sms') {
                    recipientLabel.innerText = 'Phone Number';
                    recipientInput.placeholder = 'Enter phone number';
                } else if (type === 'mail') {
                    recipientLabel.innerText = 'Email Address';
                    recipientInput.placeholder = 'Enter email address';
                } else {
                    recipientLabel.innerText = 'Push ';
                    recipientInput.placeholder = 'Enter phone number';
                }
            });
        </script>

        <div class="mb-3">
            <label for="scheduled_at">Scheduled At</label>
            <input name="scheduled_at" class="form-control" type="datetime-local">
        </div>


        {{-- <div class="mb-3">
            <label for="is_sent">Is Sent</label>
            <select name="is_sent" id="is_sent" class="form-control" required>
                <option value="true">True</option>
                <option value="false">False</option>
            </select>
        </div> --}}

        <button class="btn btn-success">Schedule Notification</button>
    </form>
</div>
@endsection
