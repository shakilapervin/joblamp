
<!-- Chat start -->
<div id="chat-box">
    <div id="chat-circle" class="btn btn-raised">
        <img src="{{ admin_asset('') }}/img/chat.svg" alt="Chat"/>
    </div>
    <div class="chat-box">
        <div class="chat-box-header">
            Chat
            <span class="chat-box-toggle"><i class="icon-close"></i></span>
        </div>
        <div class="chat-box-body">
            <div class="chat-logs">
                <div class="chat-msg self">
                    <img src="{{ admin_asset('') }}/img/user2.png" class="user" alt="">
                    <div class="chat-msg-text">Hello</div>
                </div>
                <div class="chat-msg user">
                    <img src="{{ admin_asset('') }}/img/user15.png" class="user" alt="">
                    <div class="chat-msg-text">Are we meeting today?</div>
                </div>
                <div class="chat-msg self">
                    <img src="{{ admin_asset('') }}/img/user2.png" class="user" alt="">
                    <div class="chat-msg-text">Yes, what time suits you?</div>
                </div>
                <div class="chat-msg user">
                    <img src="{{ admin_asset('') }}/img/user15.png" class="user" alt="">
                    <div class="chat-msg-text">Can we connect at 3pm?</div>
                </div>
                <div class="chat-msg self">
                    <img src="{{ admin_asset('') }}/img/user2.png" class="user" alt="">
                    <div class="chat-msg-text">Sure, Thanks. I will send you some important files.</div>
                </div>
                <div class="chat-msg user">
                    <img src="{{ admin_asset('') }}/img/user15.png" class="user" alt="">
                    <div class="chat-msg-text">Great. Thanks!</div>
                </div>
            </div>
        </div>
        <div class="chat-input">
            <form>
                <input type="text" id="chat-input" placeholder="Send a message..."/>
                <button type="submit" class="chat-submit" id="chat-submit"><i class="icon-send"></i></button>
            </form>
        </div>
    </div>
</div>
<!-- Chat end -->

</div>
<!-- Page content end -->

</div>
<!-- Page wrapper end -->

<!--**************************
    **************************
        **************************
                    Required JavaScript Files
        **************************
    **************************
**************************-->
<!-- Required jQuery first, then Bootstrap Bundle JS -->
<script src="{{ admin_asset('') }}/js/jquery.min.js"></script>
<script src="{{ admin_asset('') }}/js/bootstrap.bundle.min.js"></script>
<script src="{{ admin_asset('') }}/js/moment.js"></script>


<!-- *************
    ************ Vendor Js Files *************
************* -->
<!-- Slimscroll JS -->
<script src="{{ admin_asset('') }}/vendor/slimscroll/slimscroll.min.js"></script>
<script src="{{ admin_asset('') }}/vendor/slimscroll/custom-scrollbar.js"></script>

<!-- Polyfill JS -->
<script src="{{ admin_asset('') }}/vendor/polyfill/polyfill.min.js"></script>
<script src="{{ admin_asset('') }}/vendor/polyfill/class-list.min.js"></script>

<!-- Apex Charts -->
<script src="{{ admin_asset('') }}/vendor/apex/apexcharts.min.js"></script>
<script src="{{ admin_asset('') }}/vendor/apex/custom/graph-widgets/line-graph8.js"></script>

<!-- Peity Charts -->
<script src="{{ admin_asset('') }}/vendor/peity/peity.min.js"></script>
<script src="{{ admin_asset('') }}/vendor/peity/custom-peity.js"></script>

<!-- Rating JS -->
<script src="{{ admin_asset('') }}/vendor/rating/raty.js"></script>
<script src="{{ admin_asset('') }}/vendor/rating/raty-custom.js"></script>

<!-- jVector Maps -->
<script src="{{ admin_asset('') }}/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="{{ admin_asset('') }}/vendor/jvectormap/gdp-data.js"></script>
<script src="{{ admin_asset('') }}/vendor/jvectormap/world-mill-en.js"></script>
<!-- Custom JVector Maps -->
<script src="{{ admin_asset('') }}/vendor/jvectormap/custom/world-map-markers.js"></script>

<!-- Circleful Charts -->
<script src="{{ admin_asset('') }}/vendor/circliful/circliful.min.js"></script>
<script src="{{ admin_asset('') }}/vendor/circliful/circliful.custom.js"></script>

<!-- Main JS -->
<script src="{{ admin_asset('') }}/js/main.js"></script>
@yield('script')
</body>

</html>
