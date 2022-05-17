const { range } = require("lodash");

(function ($) {
    "use strict";
    $(document).ready(function () {
        /*==Left Navigation Accordion ==*/
        if ($.fn.dcAccordion) {
            $('#nav-accordion').dcAccordion({
                eventType: 'click',
                autoClose: true,
                saveState: true,
                disableLink: true,
                speed: 'slow',
                showCount: false,
                autoExpand: true,
                classExpand: 'dcjq-current-parent'
            });
        }
        /*==Slim Scroll ==*/
        if ($.fn.slimScroll) {
            $('.event-list').slimscroll({
                height: '305px',
                wheelStep: 20
            });
            $('.conversation-list').slimscroll({
                height: '360px',
                wheelStep: 35
            });
            $('.to-do-list').slimscroll({
                height: '300px',
                wheelStep: 35
            });
        }
        /*==Nice Scroll ==*/
        if ($.fn.niceScroll) {


            $(".leftside-navigation").niceScroll({
                cursorcolor: "#8b5c7e",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $(".leftside-navigation").getNiceScroll().resize();
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();

            $(".right-stat-bar").niceScroll({
                cursorcolor: "#fa9770",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

        }

        /*==Easy Pie chart ==*/
        if ($.fn.easyPieChart) {

            $('.notification-pie-chart').easyPieChart({
                onStep: function (from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                },
                barColor: "#39b6ac",
                lineWidth: 3,
                size: 50,
                trackColor: "#efefef",
                scaleColor: "#cccccc"

            });

            $('.pc-epie-chart').easyPieChart({
                onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                },
                barColor: "#5bc6f0",
                lineWidth: 3,
                size:50,
                trackColor: "#32323a",
                scaleColor:"#cccccc"

            });

        }

        /*== SPARKLINE==*/
        if ($.fn.sparkline) {

            $(".d-pending").sparkline([3, 1], {
                type: 'pie',
                width: '40',
                height: '40',
                sliceColors: ['#e1e1e1', '#8175c9']
            });



            var sparkLine = function () {
                $(".sparkline").each(function () {
                    var $data = $(this).data();
                    ($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
                    ($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));

                    $data.valueSpots = {
                        '0:': $data.spotColor
                    };
                    $(this).sparkline($data.data || "html", $data);


                    if ($(this).data("compositeData")) {
                        $spdata.composite = true;
                        $spdata.minSpotColor = false;
                        $spdata.maxSpotColor = false;
                        $spdata.valueSpots = {
                            '0:': $spdata.spotColor
                        };
                        $(this).sparkline($(this).data("compositeData"), $spdata);
                    };
                });
            };

            var sparkResize;
            $(window).resize(function (e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(function () {
                    sparkLine(true)
                }, 500);
            });
            sparkLine(false);



        }



        if ($.fn.plot) {
            var datatPie = [30, 50];
            // DONUT
            $.plot($(".target-sell"), datatPie, {
                series: {
                    pie: {
                        innerRadius: 0.6,
                        show: true,
                        label: {
                            show: false

                        },
                        stroke: {
                            width: .01,
                            color: '#fff'

                        }
                    }




                },

                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                    clickable: true
                },

                colors: ["#ff6d60", "#cbcdd9"]
            });
        }



        /*==Collapsible==*/
        $('.widget-head').click(function (e) {
            var widgetElem = $(this).children('.widget-collapse').children('i');

            $(this)
                .next('.widget-container')
                .slideToggle('slow');
            if ($(widgetElem).hasClass('ico-minus')) {
                $(widgetElem).removeClass('ico-minus');
                $(widgetElem).addClass('ico-plus');
            } else {
                $(widgetElem).removeClass('ico-plus');
                $(widgetElem).addClass('ico-minus');
            }
            e.preventDefault();
        });




        /*==Sidebar Toggle==*/

        $(".leftside-navigation .sub-menu > a").click(function () {
            var o = ($(this).offset());
            var diff = 80 - o.top;
            if (diff > 0)
                $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
            else
                $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
        });



        $('.sidebar-toggle-box .fa-bars').click(function (e) {

            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $('#sidebar').toggleClass('hide-left-bar');
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();
            $('#main-content').toggleClass('merge-left');
            e.stopPropagation();
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });
        $('.toggle-right-box .fa-bars').click(function (e) {
            $('#container').toggleClass('open-right-panel');
            $('.right-sidebar').toggleClass('open-right-bar');
            $('.header').toggleClass('merge-header');

            e.stopPropagation();
        });

        $('.header,#main-content,#sidebar').click(function () {
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });


        $('.panel .tools .fa').click(function () {
            var el = $(this).parents(".panel").children(".panel-body");
            if ($(this).hasClass("fa-chevron-down")) {
                $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
                el.slideUp(200);
            } else {
                $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
                el.slideDown(200); }
        });



        $('.panel .tools .fa-times').click(function () {
            $(this).parents(".panel").parent().remove();
        });

        // tool tips

        $('.tooltips').tooltip();

        // popovers

        $('.popovers').popover();


    });


})(jQuery);

$(document).ready(function() {
    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    var brands = []
    var range_price = []

    window.onload = function() {
        $('.brand-checkbox').prop('checked', false)
    }

    $('.brand-checkbox').click(function() {
        var checked = $(this).attr('value')
        if ($(this).is(':checked')) {
            brands.push(checked)
        } else {
            // Remove the element if unchecked:
            for (var i = 0; i < brands.length; i++) {
                if (brands[i] == $(this).attr('value')) {
                    brands.splice(i, 1);
                }
            }
        }
    })

    $('#min_price').change(function() {
        range_price.push($(this).val())
    })

    $('#max_price').change(function() {
        range_price.push($(this).val())
    })

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#btn-filter').click(function() {
        $('.filter-data').html('')
        $.ajax({
            url: '/shop/filter',
            type: 'GET',
            data: {
                brand_name: brands,
                min_price: range_price[0],
                max_price: range_price[1],
            },
            dataType: 'json',
            success: function(data) {
                if (data.length == 0) {
                    $('.filter-data').append('No data filter')
                } else {
                    data.forEach(element => {
                        var url_show = window.location.protocol + '//' + window.location.host + '/shop/' + element.slug
                        var url_cart = window.location.protocol + '//' + window.location.host + '/add-to-cart/' + element.id
                        let rating = element.avg_rating
                        let rating_dom = ``;
                        let cart = ``;
                        var locale = document.documentElement.lang ;
                        if (locale == 'vi') {
                            cart = `<a href="#"
                                data-url="${url_cart}"
                                class="block w-full py-1 text-center text-white bg-indigo-900 border border-indigo-900 rounded-b hover:bg-transparent hover:text-indigo-900 transition add_to_cart">
                                Thêm vào giỏ hàng
                            </a>`
                        } else {
                            cart = `<a href="#"
                                data-url="${url_cart}"
                                class="block w-full py-1 text-center text-white bg-indigo-900 border border-indigo-900 rounded-b hover:bg-transparent hover:text-indigo-900 transition add_to_cart">
                                Add To Cart
                            </a>`
                        }
                        for (let star = 1; star <= 5; star++) {
                            if (rating > 0) {
                                if(rating > 0.5) {
                                    rating_dom += `<small class="fa-solid fa-star checked"></small>`;
                                } else {
                                    rating_dom += `<small class="fa-solid fa-star-half-stroke checked"></small>`;
                                }
                            } else {
                                rating_dom += ` <small class="fa-regular fa-star checked"></small>`;
                            }
                            rating--
                        }
                        $('.filter-data').append(`
                        <div class="button-product rounded bg-white shadow-2xl overflow-hidden">
                        <div class="relative">
                            <img src="` + window.location.protocol + '//' + window.location.host + '/images/uploads/products/' + element.image_thumbnail + `"
                                class="img-product">
                            <div class="product absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center gap-2 opacity-0 transition">
                                <a href="${url_show}"
                                    class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="#"
                                    class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="pt-4 pb-3 px-4">
                            <a href="${url_show}">
                                <h4
                                    class="h-14 uppercase font-medium text-xl mb-2 text-gray-800 hover:text-indigo-900 transition">`
                                    + element.name +
                                `</h4>
                            </a>
                            <div class="flex items-baseline mb-1 space-x-2">
                                <p
                                    class="text-lg text-indigo-900 font-roboto font-semibold">`
                                    + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(element.price) + 
                                    `<input type="hidden" name="_token"
                                        value="${$('meta[name="csrf-token"]').attr('content')}">
                                </p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex gap-1">`
                                + rating_dom +
                                `</div>
                                <div class="text-xs text-gray-500 ml-3">( ` + number_format(element.avg_rating,1,'.',',')  + `)</div>
                            </div>
                        </div>`
                        + cart + `
                    </div>
                    `)
                    });
                }
            }
        })
    })
})