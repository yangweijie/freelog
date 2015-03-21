//ajax get请求
$('.ajax-get').click(function(){
	var target;
	var that = this;
	if ( $(this).hasClass('confirm') ) {
		if(!confirm('确认要执行该操作吗?')){
			return false;
		}
	}
	if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
		$.get(target).success(function(data){
			if (data.code >= 200 && data.code < 400) {
				if (data.url) {
					updateAlert(data.info + ' 页面即将自动跳转~','success');
				}else{
					updateAlert(data.info,'success');
				}
				setTimeout(function(){
					if (data.url) {
						location.href = data.url;
					}else if( $(that).hasClass('no-refresh')){
						updateAlert('default','success');
						$(that).removeClass('disabled').prop('disabled',false);
					}else{
						updateAlert('default','success', 300);
					}
				},1500);
			}else{
				updateAlert(data.info);
				setTimeout(function(){
					if (data.url) {
						location.href = data.url;
					}else{
						updateAlert();
					}
				},1500);
			}
		});
	}
	return false;
});

//ajax post submit请求
$('.ajax-post').click(function(){
	var target,query,form;
	var target_form = $(this).attr('target-form');
	var that = this;
	var nead_confirm = false;
	if( ($(this).attr('type')=='submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')) ){
		form = $('.'+target_form);
		if(form.lenght < 1 )
			alert('表单选择不正确');

		if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
			form = $('.hide-data');
			query = form.serialize();
		}else if (form.get(0)==undefined){
			return false;
		}else if ( form.get(0).nodeName=='FORM' ){
			if ( $(this).hasClass('confirm') ) {
				if(!confirm('确认要执行该操作吗?')){
					return false;
				}
			}
			if($(this).attr('url') !== undefined){
				target = $(this).attr('url');
			}else{
				target = form.get(0).action;
			}
			query = form.serialize();
		}else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
			form.each(function(k,v){
				if(v.type=='checkbox' && v.checked==true){
					nead_confirm = true;
				}
			})
			if ( nead_confirm && $(this).hasClass('confirm') ) {
				if(!confirm('确认要执行该操作吗?')){
					return false;
				}
			}
			query = form.serialize();
		}else{
			if ( $(this).hasClass('confirm') ) {
				if(!confirm('确认要执行该操作吗?')){
					return false;
				}
			}
			query = form.find('input,select,textarea').serialize();
		}
		$(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
		$.post(target,query).success(function(data){
			if (data.code >= 200 && data.code < 400) {
				if (data.url) {
					updateAlert(data.info + ' 页面即将自动跳转~','success',1500);
				}else{
					updateAlert(data.info ,'success');
				}
				setTimeout(function(){
					if( $(that).hasClass('no-refresh')){
						$(that).removeClass('disabled').prop('disabled',false);
					}
					updateAlert('default','success');
				},1500);
			}else{
				updateAlert(data.info);
				setTimeout(function(){
					$(that).removeClass('disabled').prop('disabled',false);
					if (data.url) {
						location.href = data.url;
					}else{
						updateAlert();
					}
				}, 1500);
			}
		});
	}
});

/**顶部通知栏*/
var content = $('body');
var top_alert = $('#top-alert');
var alert_offset = 0;
if($('.blog-nav').length)
    alert_offset = $('.blog-nav').outerHeight();

function checkScroll () {
    if ($(window).scrollTop() >= alert_offset) {
        top_alert.css({
            'position'  :   'fixed',
            'top'       :   0
        });
    } else {
        top_alert.css({
            'position'  :   'absolute',
            'top'       :   alert_offset
        });
    }
}

$(window).scroll(function () {
    checkScroll();
});

checkScroll();

window.updateAlert = function (text,c, reload) {
	text = text||'default';
	c = c||false;
    reload = reload || 0;
	if ( c!=false ) {
        top_alert.removeClass('error warn info success').addClass(c);
    }else{
        top_alert.removeClass('error warn info success').addClass('error');
    }
    if ( text!='default' ) {
        top_alert.find('li').text(text);
		if (top_alert.hasClass('block')) {
            top_alert.slideDown(200);
		} else {
			top_alert.addClass('block').slideDown(200);
		}
	} else {
		if (top_alert.hasClass('block')) {
			top_alert.removeClass('block').slideUp(200);
		}
	}
    top_alert.find('.close').on('click', function(){
        top_alert.removeClass('block').slideUp(200);
    });
    if(reload){
        setTimeout(function(){
            top_alert.removeClass('block').slideUp(reload/2, function(){
                location.reload(true);
            });
        }, reload/2);
    }
};