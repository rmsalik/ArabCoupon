var DatatablesAdvancedColumnRendering = {
    init: function () {
        $("#m_table_1").DataTable({
            responsive: !0,
            bStateSave: true,
            order: [], //Initial no order.
            paging: !0,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
            //columnDefs: [
            /*{
             targets: 0, title: "Agent", render: function (a, e, n, s) {
             var t = mUtil.getRandomInt(1, 14);
             return t > 8 ? '\n                                <div class="m-card-user m-card-user--sm">\n                                    <div class="m-card-user__pic">\n                                        <img src="https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/assets/app/media/img/users/100_' + t + '.jpg" class="m--img-rounded m--marginless" alt="photo">\n                                    </div>\n                                    <div class="m-card-user__details">\n                                        <span class="m-card-user__name">' + n[2] + '</span>\n                                        <a href="" class="m-card-user__email m-link">' + n[3] + "</a>\n                                    </div>\n                                </div>" : '\n                                <div class="m-card-user m-card-user--sm">\n                                    <div class="m-card-user__pic">\n                                        <div class="m-card-user__no-photo m--bg-fill-' + ["success", "brand", "danger", "accent", "warning", "metal", "primary", "info"][mUtil.getRandomInt(0, 7)] + '"><span>' + n[2].substring(0, 1) + '</span></div>\n                                    </div>\n                                    <div class="m-card-user__details">\n                                        <span class="m-card-user__name">' + n[2] + '</span>\n                                        <a href="" class="m-card-user__email m-link">' + n[3] + "</a>\n                                    </div>\n                                </div>"
             }
             }, {
             targets: 1, render: function (a, e, n, s) {
             return '<a class="m-link" href="mailto:' + a + '">' + a + "</a>"
             }
             }, {
             targets: -1, title: "Actions", orderable: !1, render: function (a, e, n, s) {
             return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
             }
             }, {
             targets: 4, render: function (a, e, n, s) {
             var t = {
             1: {title: "Pending", class: "m-badge--brand"},
             2: {title: "Delivered", class: " m-badge--metal"},
             3: {title: "Canceled", class: " m-badge--primary"},
             4: {title: "Success", class: " m-badge--success"},
             5: {title: "Info", class: " m-badge--info"},
             6: {title: "Danger", class: " m-badge--danger"},
             7: {title: "Warning", class: " m-badge--warning"}
             };
             return void 0 === t[a] ? a : '<span class="m-badge ' + t[a].class + ' m-badge--wide">' + t[a].title + "</span>"
             }
             }, {
             targets: 5, render: function (a, e, n, s) {
             var t = {
             1: {title: "Online", state: "danger"},
             2: {title: "Retail", state: "primary"},
             3: {title: "Direct", state: "accent"}
             };
             return void 0 === t[a] ? a : '<span class="m-badge m-badge--' + t[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + t[a].state + '">' + t[a].title + "</span>"
             }
             }*/
            //]
        })
    }
};
var DatatablesAdvancedColumnRenderingSet = {
    init: function () {
        $(".rendering_tbl").DataTable({
            responsive: !0,
            bStateSave: true,
            paging: !0,
            order: [], //Initial no order.
            columnDefs: [/*{
             targets: 0, title: "Agent", render: function (a, e, n, s) {
             var t = mUtil.getRandomInt(1, 14);
             return t > 8 ? '\n                                <div class="m-card-user m-card-user--sm">\n                                    <div class="m-card-user__pic">\n                                        <img src="https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/assets/app/media/img/users/100_' + t + '.jpg" class="m--img-rounded m--marginless" alt="photo">\n                                    </div>\n                                    <div class="m-card-user__details">\n                                        <span class="m-card-user__name">' + n[2] + '</span>\n                                        <a href="" class="m-card-user__email m-link">' + n[3] + "</a>\n                                    </div>\n                                </div>" : '\n                                <div class="m-card-user m-card-user--sm">\n                                    <div class="m-card-user__pic">\n                                        <div class="m-card-user__no-photo m--bg-fill-' + ["success", "brand", "danger", "accent", "warning", "metal", "primary", "info"][mUtil.getRandomInt(0, 7)] + '"><span>' + n[2].substring(0, 1) + '</span></div>\n                                    </div>\n                                    <div class="m-card-user__details">\n                                        <span class="m-card-user__name">' + n[2] + '</span>\n                                        <a href="" class="m-card-user__email m-link">' + n[3] + "</a>\n                                    </div>\n                                </div>"
             }
             }, {
             targets: 1, render: function (a, e, n, s) {
             return '<a class="m-link" href="mailto:' + a + '">' + a + "</a>"
             }
             }, {
             targets: -1, title: "Actions", orderable: !1, render: function (a, e, n, s) {
             return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
             }
             }, {
             targets: 4, render: function (a, e, n, s) {
             var t = {
             1: {title: "Pending", class: "m-badge--brand"},
             2: {title: "Delivered", class: " m-badge--metal"},
             3: {title: "Canceled", class: " m-badge--primary"},
             4: {title: "Success", class: " m-badge--success"},
             5: {title: "Info", class: " m-badge--info"},
             6: {title: "Danger", class: " m-badge--danger"},
             7: {title: "Warning", class: " m-badge--warning"}
             };
             return void 0 === t[a] ? a : '<span class="m-badge ' + t[a].class + ' m-badge--wide">' + t[a].title + "</span>"
             }
             }, {
             targets: 5, render: function (a, e, n, s) {
             var t = {
             1: {title: "Online", state: "danger"},
             2: {title: "Retail", state: "primary"},
             3: {title: "Direct", state: "accent"}
             };
             return void 0 === t[a] ? a : '<span class="m-badge m-badge--' + t[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + t[a].state + '">' + t[a].title + "</span>"
             }
             }*/]
        })
    }
};
var reporting = {
    init: function () {
        $("#reporting").DataTable({
            "oSearch": {
                "bSmart": false,
                "bRegex": true
            },
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            responsive: !0,
            paging: !0,
            "order": [],
            initComplete: function () {
                this.api().columns().every( function (index) {
                    var column = this;
                    var select = $('<select class="form-control m-input m-input--air"><option value="">Filter by '+this.header().innerHTML+'</option></select>')
                        .appendTo($("#filters").find(".m-form__group").eq(column.index()))
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },
            columnDefs: [
                /*{
                 targets: 0, title: "Agent", render: function (a, e, n, s) {
                 var t = mUtil.getRandomInt(1, 14);
                 return t > 8 ? '\n                                <div class="m-card-user m-card-user--sm">\n                                    <div class="m-card-user__pic">\n                                        <img src="https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/assets/app/media/img/users/100_' + t + '.jpg" class="m--img-rounded m--marginless" alt="photo">\n                                    </div>\n                                    <div class="m-card-user__details">\n                                        <span class="m-card-user__name">' + n[2] + '</span>\n                                        <a href="" class="m-card-user__email m-link">' + n[3] + "</a>\n                                    </div>\n                                </div>" : '\n                                <div class="m-card-user m-card-user--sm">\n                                    <div class="m-card-user__pic">\n                                        <div class="m-card-user__no-photo m--bg-fill-' + ["success", "brand", "danger", "accent", "warning", "metal", "primary", "info"][mUtil.getRandomInt(0, 7)] + '"><span>' + n[2].substring(0, 1) + '</span></div>\n                                    </div>\n                                    <div class="m-card-user__details">\n                                        <span class="m-card-user__name">' + n[2] + '</span>\n                                        <a href="" class="m-card-user__email m-link">' + n[3] + "</a>\n                                    </div>\n                                </div>"
                 }
                 }, {
                 targets: 1, render: function (a, e, n, s) {
                 return '<a class="m-link" href="mailto:' + a + '">' + a + "</a>"
                 }
                 }, {
                 targets: -1, title: "Actions", orderable: !1, render: function (a, e, n, s) {
                 return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                 }
                 }, {
                 targets: 4, render: function (a, e, n, s) {
                 var t = {
                 1: {title: "Pending", class: "m-badge--brand"},
                 2: {title: "Delivered", class: " m-badge--metal"},
                 3: {title: "Canceled", class: " m-badge--primary"},
                 4: {title: "Success", class: " m-badge--success"},
                 5: {title: "Info", class: " m-badge--info"},
                 6: {title: "Danger", class: " m-badge--danger"},
                 7: {title: "Warning", class: " m-badge--warning"}
                 };
                 return void 0 === t[a] ? a : '<span class="m-badge ' + t[a].class + ' m-badge--wide">' + t[a].title + "</span>"
                 }
                 }, {
                 targets: 5, render: function (a, e, n, s) {
                 var t = {
                 1: {title: "Online", state: "danger"},
                 2: {title: "Retail", state: "primary"},
                 3: {title: "Direct", state: "accent"}
                 };
                 return void 0 === t[a] ? a : '<span class="m-badge m-badge--' + t[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + t[a].state + '">' + t[a].title + "</span>"
                 }
                 }*/]
        })
    }
};
jQuery(document).ready(function () {
    DatatablesAdvancedColumnRendering.init();
    DatatablesAdvancedColumnRenderingSet.init();
    reporting.init();
    $('.m-menu__link').click(function(){
        $(".rendering_tbl").DataTable({
            destroy: true,
            drawCallback: function () {
                this.api().state.clear();
            }
        });
        /*$("#m_table_1").DataTable({
            destroy: true,
            drawCallback: function () {
                this.api().state.clear();
            }
        });*/
    });

});