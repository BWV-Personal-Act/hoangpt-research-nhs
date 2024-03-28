<x-error-layout>
    <section class="error-container">
        <div class="error-body">
            <div class="error-code">503</div>
            <div class="error-text">
                <div class="error-text-title">メンテナンス中</div>
                <div class="error-text-subtitle">{{ $exception->getMessage() }}</div>
            </div>
        </div>
    </section>
</x-error-layout>