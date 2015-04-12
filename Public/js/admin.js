//dom加载完成后执行的js
;$(function(){
    $(document).ajaxStart(function() {
        NProgress.start();
    });

    $(document).ajaxStop(function() {
        NProgress.done();
    });

	//全选的实现
	$("input[name='checkAll']").click(function(){
		$(".ids").prop("checked", this.checked);
	});
	$(".ids").click(function(){
		var option = $(".ids");
		option.each(function(i){
			if(!this.checked){
				$("input[name='checkAll']").prop("checked", false);
				return false;
			}else{
				$("input[name='checkAll']").prop("checked", true);
			}
		});
	});

	/**顶部警告栏*/
	var content = $('#main');
	var top_alert = $('#top-alert');
    var alert_offect = 0;
    if($('.typecho-head-nav').length)
        alert_offect = $('.typecho-head-nav').outerHeight();

    function checkScroll () {
        if ($(window).scrollTop() >= alert_offect) {
            top_alert.css({
                'position'  :   'fixed',
                'top'       :   0
            });
        } else {
            top_alert.css({
                'position'  :   'absolute',
                'top'       :   alert_offect
            });
        }
    }

    $(window).scroll(function () {
        checkScroll();
    });

    checkScroll();

    //按钮组
    (function(){
        //按钮组(鼠标悬浮显示)
        })();

        // 独立域表单获取焦点样式
        $(".text").focus(function(){
            $(this).addClass("focus");
        }).blur(function(){
            $(this).removeClass('focus');
        });
        $("textarea").focus(function(){
            $(this).closest(".textarea").addClass("focus");
        }).blur(function(){
            $(this).closest(".textarea").removeClass("focus");
        });
    });

/* 上传图片预览弹出层 */
$(function(){
    $(window).resize(function(){
        var winW = $(window).width();
        var winH = $(window).height();
        $(".upload-img-box").click(function(){
        	//如果没有图片则不显示
        	if($(this).find('img').attr('src') === undefined){
        		return false;
        	}
            // 创建弹出框以及获取弹出图片
            var imgPopup = "<div id=\"uploadPop\" class=\"upload-img-popup\"></div>"
            var imgItem = $(this).find(".upload-pre-item").html();

            //如果弹出层存在，则不能再弹出
            var popupLen = $(".upload-img-popup").length;
            if( popupLen < 1 ) {
                $(imgPopup).appendTo("body");
                $(".upload-img-popup").html(
                    imgItem + "<a class=\"close-pop\" href=\"javascript:;\" title=\"关闭\"></a>"
                );
            }

            // 弹出层定位
            var uploadImg = $("#uploadPop").find("img");
            var popW = uploadImg.width();
            var popH = uploadImg.height();
            var left = (winW -popW)/2;
            var top = (winH - popH)/2 + 50;
            $(".upload-img-popup").css({
                "max-width" : winW * 0.9,
                "left": left,
                "top": top
            });
        });

        // 关闭弹出层
        $("body").on("click", "#uploadPop .close-pop", function(){
            $(this).parent().remove();
        });
    }).resize();

    // 缩放图片
    function resizeImg(node,isSmall){
        if(!isSmall){
            $(node).height($(node).height()*1.2);
        } else {
            $(node).height($(node).height()*0.8);
        }
    }
})

function highlight_sidebar(url) {
    $('.nav-collapse>.nav>li').removeClass('active');
    $('.nav .dropdown-menu>li>a[href*="'+url+'"]').parent().addClass('active').parents('.dropdown').addClass('active');
    $('.nav-collapse .nav li a[href*="'+url+'"]').parent().addClass('active');
}

//标签页切换(无下一步)
function showTab() {
    $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();
}

//标签页切换(有下一步)
function nextTab() {
     $(".tab-nav li").click(function(){
        var self = $(this), target = self.data("tab");
        self.addClass("current").siblings(".current").removeClass("current");
        window.location.hash = "#" + target.substr(3);
        $(".tab-pane.in").removeClass("in");
        $("." + target).addClass("in");
        showBtn();
    }).filter("[data-tab=tab" + window.location.hash.substr(1) + "]").click();

    $("#submit-next").click(function(){
        $(".tab-nav li.current").next().click();
        showBtn();
    });
}

// 下一步按钮切换
function showBtn() {
    var lastTabItem = $(".tab-nav li:last");
    if( lastTabItem.hasClass("current") ) {
        $("#submit").removeClass("hidden");
        $("#submit-next").addClass("hidden");
    } else {
        $("#submit").addClass("hidden");
        $("#submit-next").removeClass("hidden");
    }
}

//导航高亮
function highlight_subnav(url){
    $('#typecho-nav-list ul.child li').find('a[href*="'+url+'"]').closest('li').addClass('focus');
}

$(function(){
    //导航子页面高亮选中
    highlight_sidebar(url);
});
