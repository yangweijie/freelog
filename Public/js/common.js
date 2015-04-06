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
						notify(data.info + ' 页面即将自动跳转~','success');
					}else{
						notify(data.info,'success');
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
					notify(data.info, 'error');
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
	$('.ajax-post').on('click', function(){
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
						notify(data.info + ' 页面即将自动跳转~','success');
					}else{
						notify(data.info ,'success');
					}
					setTimeout(function(){
						$(that).removeClass('disabled').prop('disabled',false);
						if(data.url)
							location.href = data.url;
					},1500);
				}else{
					notify(data.info, 'error');
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

	//ajax PUT 的实现
	$('.ajax-put').on('click', function(){
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
				$.ajax({
					url: target,
					type: 'put',
					data:query,
					success: function(data) {
			            if (data.code >= 200 && data.code < 400) {
							console.log('success');
							if (data.url) {
								notify(data.info + ' 页面即将自动跳转~','success');
							}else{
								notify(data.info ,'success');
							}
							setTimeout(function(){
								$(that).removeClass('disabled').prop('disabled',false);
								if(data.url)
									location.href = data.url;
							},1500);
						}else{
							notify(data.info, 'error');
							setTimeout(function(){
								$(that).removeClass('disabled').prop('disabled',false);
								if (data.url) {
									location.href = data.url;
								}
							}, 1500);
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						var code = jqXHR.status;
						console.log(jqXHR);
						if(404 == code ){
							notify(jqXHR.responseJSON.info ,'error');
						}else if(412 == code){
							notify('记录不存在，无法更新' ,'error');
						}
					}
				});
			}
			return false;
		});

	//ajax  DELETE 的实现
	$('.ajax-delete').click(function(){
		var target = $(this).attr('href');
		var that = this;
		var callback = $(this).attr('callback');
		if ( $(this).hasClass('confirm') ) {
			if(!confirm('确认要执行该操作吗?')){
				return false;
			}
		}
		$.ajax({
			url: target,
			type: 'delete',
			success: function(data) {
	            if (data.code >= 200 && data.code < 400) {
					console.log('success');
					if (data.url) {
						notify(data.info + ' 页面即将自动跳转~','success');
					}else{
						notify(data.info ,'success');
					}
					if(callback)
						callback();
					setTimeout(function(){
						$(that).removeClass('disabled').prop('disabled',false);
						if(data.url)
							location.href = data.url;
					},1500);
				}else{
					notify(data.info, 'error');
					setTimeout(function(){
						$(that).removeClass('disabled').prop('disabled',false);
						if (data.url) {
							location.href = data.url;
						}
					}, 1500);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				var code = jqXHR.status;
				if(404 == code ){
					notify(data.info ,'error');
				}else if(412 == code){
					notify('记录已经被删除了' ,'error');
				}
			}
		});
		return false;
	});
});



function ajaxForm(ele, target, data, callback){
	var that = ele;
	var callback = callback || false;
	$.post(target,data).success(function(data){
		if (data.code >= 200 && data.code < 400) {
			console.log('success');
			if (data.url) {
				notify(data.info + ' 页面即将自动跳转~','success');
			}else{
				notify(data.info ,'success');
			}
			if(callback)
				callback();
			setTimeout(function(){
				$(that).removeClass('disabled').prop('disabled',false);
				if(data.url)
					location.href = data.url;
			},1500);
		}else{
			notify(data.info, 'error');
			setTimeout(function(){
				$(that).removeClass('disabled').prop('disabled',false);
				if (data.url) {
					location.href = data.url;
				}
			}, 1500);
		}
	});

	//搜索
	$('#search').submit(function(){
        var url = '/search/'+ $('#search input[name="kw"]').val();
        location.href = url;
        return false;
    });
}
/**顶部通知栏*/
var content = $('body');

window.notify = function (text,c, reload) {
	text = text||'default';
	c = c||'error';
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