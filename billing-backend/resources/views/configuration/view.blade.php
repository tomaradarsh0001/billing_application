@extends('layouts.app')
@section('title', 'Configuration Details')
@section('content')
<title>Configurations</title>
<style>
    .theme-colors {
    display: flex;
    gap: 10px; 
}

.color-block {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.badges {
    width: 60px;
    height: 60px; 
    border-radius: 5px; 
    display: block;
}

.smalls {
    margin-top: 5px; 
    font-size: 10px;
    color: #555; 
}
.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.6); 
    display: none; 
    display: flex;
    justify-content: center; 
    align-items: center; 
}

.modal-content {
    position: relative;
    background-color: #fff;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: auto; 
    max-width: 90%; 
    max-height: 80vh; 
    overflow: hidden;
    display: flex; 
    justify-content: center;
    align-items: center; 
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.image-logo {
    transition: transform 0.3s ease-in-out;
}

.image-logo:hover {
    transform: scale(1.2); 
}

</style>
    <div class="main_content_iner">
        <div class="col-lg-9">
            <div class="card_box box_shadow position-relative ">
                <div class="white_box_tittle">
                    <div class="main-title2">
                        <h4 class="nowrap">Configuration Details</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong>Application Name:</strong> {{ $configuration->app_name }}
                    </div>
                    <div class="mb-3">
                        <strong>Application Purpose:</strong> {{ $configuration->app_purpose }}
                    </div>
                    <div class="mb-3">
                        <strong>Tagline:</strong> {{ $configuration->app_tagline }}
                    </div>
                    

                    <div class="mb-3">
                        <div class="theme-colors">
        <strong>Theme:</strong>
        <div class="color-block">
        <small class="smalls">Primary Light</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_primary_light }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_primary_light }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Primary Dark</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_primary_dark }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_primary_dark }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Secondary Light</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_secondary_light }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_secondary_light }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Secondary Dark</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_secondary_dark }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_secondary_dark }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Background</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_background }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_background }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Text Primary</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_text_primary }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_text_primary }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Text Secondary</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_text_secondary }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_text_secondary }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Circular SVG Login</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_svg_login }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_svg_login }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Circular SVG Signup</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_svg_signup }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_svg_signup }}</small>
        </div>
        <div class="color-block">
        <small class="smalls">Page Links</small>
            <span class="badge" style="background-color: {{ $configuration->app_theme_links }};">&nbsp;</span>
            <small class="smalls">{{ $configuration->app_theme_links }}</small>
        </div>
    </div>
</div>

                    <div class="mb-3">
                        @if($configuration->app_logo)
                        <div class="mb-3">
                        <div class="theme-colors">
        <strong>Logo:</strong>
        <div class="color-block">
                            <img class="image-logo" src="{{ asset('storage/' . $configuration->app_logo) }}" alt="Logo" width="35" onclick="openModal('{{ asset('storage/' . $configuration->app_logo) }}')">
                            <small class="smalls">Tap Image to View</small>
                        @else
                            <span>No Logo</span>
                        @endif
                    </div>
                    </div>
                    </div>
                    </div>
                    <a href="{{ route('configuration.index') }}" class="btn btn-secondary">Back to List</a>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
<div id="logoModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="Logo" style="width: 70%; max-height: 80vh; object-fit: contain;">
    </div>
</div>

<script>
    function openModal(imageSrc) {
        var modal = document.getElementById("logoModal");
        var modalImage = document.getElementById("modalImage");

        modalImage.src = imageSrc;
        modal.style.display = "flex";
    }

    function closeModal() {
        var modal = document.getElementById("logoModal");
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("logoModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>


@endsection
