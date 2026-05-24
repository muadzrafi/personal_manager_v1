<footer class="main-footer">
    <strong>&copy; {{ date('Y') }} Personal Manager.</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
 
{{-- URUTAN WAJIB: jQuery → Bootstrap → OverlayScrollbars → AdminLTE --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
 
<!-- {{-- Slot untuk @push('scripts') — HANYA di sini, JANGAN duplikat di master.blade.php --}}
@stack('scripts') -->
 