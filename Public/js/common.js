$(function(){
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
							$(that).removeClass('disabled').prop('disabled',false);
						}else{
							location.reload(true);
						}
					},1500);
				}else{
					updateAlert(data.info, 'error');
					setTimeout(function(){
						if (data.url) {
							location.href = data.url;
						}
					},1500);
				}
			});
		}
		return false;
	});

	//ajax post submit请求
	$('.ajax-post').on('click', function(e){
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
					console.log('success');
					if (data.url) {
						updateAlert(data.info + ' 页面即将自动跳转~','success');
					}else{
						updateAlert(data.info ,'success');
					}
					setTimeout(function(){
						if( $(that).hasClass('no-refresh')){
							$(that).removeClass('disabled').prop('disabled',false);
						}
						if(data.url)
							location.href = data.url;
					},1500);
				}else{
					updateAlert(data.info, 'error');
					setTimeout(function(){
						$(that).removeClass('disabled').prop('disabled',false);
						if (data.url) {
							location.href = data.url;
						}
					}, 1500);
				}
			});
		}
		return false;
	});

})

/**顶部通知栏*/
var content = $('body');

window.updateAlert = function (text,c, reload) {
	text = text||'default';
	c = c||'success';
    reload = reload || 0;
    $.notifyBar({
        html: text,
        cssClass: c,
        onHide: function(){
        	if(reload){
        		setTimeout(function(){
		            location.reload(true);
		        }, reload/2);
        	}
        }
    });
};