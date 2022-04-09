<!-- BEGIN: Vendor JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if ($configData['blankPage'] === false)
    <script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js" integrity="sha512-eiqtDDb4GUVCSqOSOTz/s/eiU4B31GrdSb17aPAA4Lv/Cjc8o+hnDvuNkgXhSI5yHuDvYkuojMaQmrB5JB31XQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@yield('page-script')
<script>
            $(function() {
                let ip_address = '127.0.0.1';
                let socket_port = '9699';
                let socket = io(ip_address + ':' + socket_port);

                socket.on('getStockServer', (message,id,companyId) => {
                    const  companyIdServer = {{!empty(auth()->user()->company_id) ? auth()->user()->company_id : -1}};

                    if (companyId == companyIdServer) {
                        notificationHam("Stok Uyarısı",message,"error",2000)
                    id.map((val)=>{
                        $("span[pro_id='"+val["id"]+"']").html(val["adet"])
                    })
                    }

                });

    });
    </script>
<!-- END: Page JS-->
