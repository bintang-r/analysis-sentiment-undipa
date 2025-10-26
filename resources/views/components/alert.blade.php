@push('styles')
    <style>
        .spin-animation {
            display: inline-block;
            animation: spin 1s linear infinite;
            font-size: 2.5rem;
            font-weight: bold;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .custom-alert {
            position: fixed;
            top: 50px;
            right: -400px;
            min-width: 300px;
            max-width: 400px;
            z-index: 1055;
            border-radius: 10px;
            transition: right 0.6s ease-in-out, opacity 0.6s ease-in-out;
            opacity: 0;
        }

        .custom-alert.show {
            right: 20px;
            opacity: 1;
        }

        .custom-alert.hide {
            right: -400px;
            opacity: 0;
        }
    </style>
@endpush


<div class="d-print-none">
    <div style="z-index: 9999; position: fixed; bottom: 20px; right: 20px;"
        class="d-flex flex-column align-items-end gap-2">

        <div class="btn btn-blue" id="loading-indicator" wire:loading.delay>
            <i class="las la-sync-alt spin-animation"></i>
        </div>

        <span class="btn btn-red" id="loading-indicator" wire:offline>
            <i class="fs-1 las la-plane p-2"></i> Anda sedang offline.
        </span>
    </div>

    @if (session('alert'))
        <div class="custom-alert alert alert-{{ $type }} alert-dismissible bg-white shadow-lg" role="alert">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <h1 class="text-{{ $type }} las la-{{ $icon }}"></h1>
                </div>

                <div>
                    <h4 class="alert-title">{{ $message }}</h4>
                    <div class="text-muted">{{ $detail }}</div>
                </div>
            </div>

            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Livewire.hook("morph.updated", () => {
                const alertBox = document.querySelector(".custom-alert");
                if (alertBox) {
                    alertBox.classList.remove("show", "hide");

                    setTimeout(() => {
                        alertBox.classList.add("show");
                    }, 100);

                    setTimeout(() => {
                        alertBox.classList.remove("show");
                        alertBox.classList.add("hide");
                    }, 5000);
                }
            });
        });
    </script>
@endpush
