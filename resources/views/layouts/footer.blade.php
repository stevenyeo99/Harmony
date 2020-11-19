<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Harmony System {{ date('Y') }}</span>
            <br>
            <span>Tanjung Pinang</span>
        </div>
    </div>
</footer>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        setPlatformForWaPage();
    });

    function setPlatformForWaPage() {
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            console.log("Mobile");
            $("a#waContact").attr("href", "https://wa.me/6281378099317?text=Halo Harmony Support");
        } else {
            console.log("Website");
            $("a#waContact").attr("href", "https://web.whatsapp.com/send?phone=6281378099317&&text=Halo Harmony Support");
        }
    }
</script>
@endpush