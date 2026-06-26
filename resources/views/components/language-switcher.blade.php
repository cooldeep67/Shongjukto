<div class="language-switcher">
    <div class="btn-group" role="group">
        <a href="{{ route('language.switch', ['locale' => 'en']) }}" 
           class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
            {{ __('messages.english') }}
        </a>
        <a href="{{ route('language.switch', ['locale' => 'bn']) }}" 
           class="btn btn-sm {{ app()->getLocale() == 'bn' ? 'btn-primary' : 'btn-outline-primary' }}">
            {{ __('messages.bengali') }}
        </a>
    </div>
    

</div>

<style>
.language-switcher {
    margin-left: 10px;
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}


</style>
