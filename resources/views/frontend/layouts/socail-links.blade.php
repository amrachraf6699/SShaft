<ul class="socail-links fixed">
    @if ($setting->facebook)
        <li class="facebook"><a href="{{ $setting->facebook }}" aria-label="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
    @endif
    @if ($setting->twitter)
        <li class="twitter"><a href="{{ $setting->twitter }}" aria-label="twitter" target="_blank"><i class="fab fa-twitter"></i></a></li>
    @endif
    @if ($setting->youtube)
        <li class="youtube"><a href="{{ $setting->youtube }}" aria-label="pinterest" target="_blank"><i class="fab fa-youtube"></i></a></li>
    @endif
    @if ($setting->instagram)
        <li class="instagram"><a href="{{ $setting->instagram }}" aria-label="instagram" target="_blank"><i class="fab fa-instagram"></i></a></li>
    @endif
    {{-- @if ($setting->snapchat)
        <li class="snapchat"><a href="{{ $setting->snapchat }}" aria-label="snapchat" target="_blank"><i class="fab fa-snapchat"></i></a></li>
    @endif --}}
    @if ($setting->whatsapp)
        <li class="whatsapp"><a href="https://wa.me/{{ $setting->whatsapp }}" aria-label="whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a><span></span></li>
    @endif
</ul>
