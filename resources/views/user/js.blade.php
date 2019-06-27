@section('scripts')
<script type="text/javascript">
    $('.updateLevelF').hide();
    $('.updateLevelBtn').click(function(){
        $(this).parent().find('form').show();
    });
    var jifen_alias = '{{ getSettingValueByKeyCache('credits_alias') }}';
    function editScale(id, type) {
        $('#scale'+type+'_'+id).hide();
        $('#scale'+type+'_edit_'+id).show();
    }
    function cancelNewScale(id, type) {
        $('#scale'+type+'_'+id).show();
        $('#scale'+type+'_edit_'+id).hide();
    }
    function saveNewScale(id, type) {

        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zcjy/changeScale/'+ id + '/' +  $('#scale'+type+'_new_'+id).val() + '?type=' + type,
            type: 'GET',
            data: '',
            success: function(data) {
                if (data.code == 1) {
                    alert(data.message);
                    return;
                }
                if (data.code == 0) {
                    $('#scale'+type+'_'+id+' span').text(data.message);
                    $('#scale'+type+'_'+id).show();
                    $('#scale'+type+'_edit_'+id).hide();
                }
            },
        });
    }

    function editName(id) {
        $('#name_'+id).hide();
        $('#name_edit_'+id).show();
    }
    function cancelNewName(id) {
        $('#name_'+id).show();
        $('#name_edit_'+id).hide();
    }
    function saveNewName(id) {

        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zcjy/changeName/'+ id + '?name=' + $('#name_new_'+id).val(),
            type: 'GET',
            data: '',
            success: function(data) {
                if (data.code == 1) {
                    alert(data.message);
                    return;
                }
                if (data.code == 0) {
                    $('#name_'+id+' span').text(data.message);
                    $('#name_'+id).show();
                    $('#name_edit_'+id).hide();
                }
            },
        });
    }


    // function member_status_change(id, days) {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: '/zcjy/kaitonghuiyuan/' + id,
    //         type: 'GET',
    //         data: 'days='+days,
    //         success: function(data) {
    //             if (data.code == 1) {
    //                 alert(data.message);
    //                 return;
    //             }
    //             if (data.code == 0) {
    //                 if (data.message == '是') {
    //                     //$('#member_status_'+id).text('是');
    //                     $('#member_change_'+id).text('取消会员');
    //                     $('#member_change_'+id).removeClass('label-success');
    //                     $('#member_change_'+id).addClass('label-danger');
    //                 } else {
    //                     //$('#member_status_'+id).text('否');
    //                     $('#member_change_'+id).text('成为会员');
    //                     $('#member_change_'+id).removeClass('label-danger');
    //                     $('#member_change_'+id).addClass('label-success');
    //                 }
    //                 alert('操作成功');
    //             }
    //         },
    //     });
    // }


    function changeShareStatus(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zcjy/kaitongfenxiang/' + id,
            type: 'GET',
            success: function(data) {
                if (data.code == 1) {
                    alert(data.message);
                    return;
                }
                if (data.code == 0) {
                    if (data.message == '是') {
                        $('#member_share_'+id).text('是');
                        $('#member_share_'+id).removeClass('label-success');
                        $('#member_share_'+id).addClass('label-danger');
                    } else {
                        $('#member_share_'+id).text('否');
                        $('#member_share_'+id).removeClass('label-danger');
                        $('#member_share_'+id).addClass('label-success');
                    }
                    alert('操作成功');
                }
            },
        });
    }


    $('#userDaySet').hide();

    function member_status_change(id, obj) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zcjy/kaitonghuiyuan/' + id,
            type: 'GET',
            data: obj,
            success: function(data) {
                if (data.code == 1) {
                    alert(data.message);
                    return;
                }
                if (data.code == 0) {
                    if (data.message == '是') {
                        $('#member_status_'+id).text('是');
                        $('#member_change_'+id).text('取消会员');
                        $('#member_change_'+id).removeClass('label-success');
                        $('#member_change_'+id).addClass('label-danger');
                        $('#member_time_'+id).text(CurentTime());
                        console.log(CurentTime());
                    } else {
                        $('#member_status_'+id).text('否');
                        $('#member_change_'+id).text('成为会员');
                        $('#member_change_'+id).removeClass('label-danger');
                        $('#member_change_'+id).addClass('label-success');
                        $('#member_time_'+id).text('');
                    }
                    alert('操作成功');
                }
            },
        });
    }

    var user_id  = 0;
    function changeMemberStatus(id) {
        event.preventDefault();
        user_id  = id;
        var status = $('#member_change_'+id).text();
        if ( status == '取消会员') {
            member_status_change(id, 0);
        }
        else{
                layer.open({
                    type: 1,
                    closeBtn: false,
                    shift: 7,
                    shadeClose: true,
                    title:'请选择会员',
                    // area: ['60%', '680px'],
                    content: $('#userDaySet').html()
                });
                // $('.days_end').datepicker({
                //     format: "yyyy-mm-dd",
                //     language: "zh-CN",
                //     todayHighlight: true
                // });
        }
    }

    function changeLeader(id) {
        event.preventDefault();
        user_id  = id;

        layer.open({
            type: 1,
            closeBtn: false,
            shift: 7,
            shadeClose: true,
            title:'推荐人设置',
            content: $('#setleader').html()
        });

    }

    function saveLeader() {
        //alert($('input[name=sharecode]:eq(1)').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/zcjy/save_leader/' + user_id,
            type: 'GET',
            data: { code: $('input[name=sharecode]:eq(1)').val() },
            success: function(data) {
                if (data.code == 1) {
                    alert(data.message);
                    return;
                }
                if (data.code == 0) {
                    alert('操作成功');
                    location.reload();
                }
            },
        });
    }

    function openMember() {
        var level = $('select[name=level]:eq(1)').val();
        console.log(level);
        if(level == 0  || level == ''){
            alert('请选择会员卡!');
            return false;
        }
        var days = $('input[name=days]:eq(1)').val();
        if(days == 0  || days == ''){
            alert('请选择会员天数!');
            return false;
        }
        layer.closeAll();
        member_status_change(user_id, {days:days,level:level});
    }

    function CurentTime()
    { 
        var now = new Date();
       
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日
       
        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
        var ss = now.getSeconds();          //秒
        var clock = year + "-";
       
        if(month < 10)
            clock += "0";
       
        clock += month + "-";
       
        if(day < 10)
            clock += "0";
           
        clock += day + " ";
       
        if(hh < 10)
            clock += "0";
           
        clock += hh + ":";
        if (mm < 10) clock += '0'; 
        clock += mm + ":"; 

        if(ss <10) clock += '0';
        clock +=ss;
        return(clock); 
    } 

    @if(isset($user))
       //积分修改操作
     $('#creditsEdit').click(function(){
          var credits=$(this).parent().find('span').text();
          var userid=$(this).data('id');
           layer.open({
            type: 1,
            closeBtn: false,
            shift: 7,
            shadeClose: true,
            content: "<div style='width:350px; padding: 0 15px;'><div style='width:320px;' class='form-group has-feedback'><p>当前"+jifen_alias+"</p><input  class='form-control' type='text'  name='credits' value='"+credits+"' disabled/></div>" +
            "<div style='width:320px;' class='form-group has-feedback'><p>输入"+jifen_alias+"变动</p><input class='form-control' type='number' name='credits_change' value='' /></div>"+
            "<button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary btn-lg' onclick='updateCredits("+userid+")'>修改</button></div>"
             });
     });

     //积分修改对接
     function updateCredits(userid)
     {
            if($('input[name=credits_change]').val()==null || $('input[name=credits_change]').val()=='')
            {
                  layer.open({
                        content: '请输入变动值'
                        ,skin: 'msg'
                      });
                return false;
            }
            var credits=parseFloat($('input[name=credits]').val());

            var credits_change=credits_change<0?-parseFloat(-($('input[name=credits_change]').val())):parseFloat($('input[name=credits_change]').val());
            console.log(credits+":"+credits_change);
            var credits_final=credits+credits_change;
            if(credits_change<0 && credits_final<0){
                layer.open({
                  content: '变动不能大于原'+jifen_alias
                  ,skin: 'msg'
                });
                return false;
            }
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{!! route('user.update_credit',$user->id) !!}',
                type:"GET",
                data:{
                    credits_change:credits_change
                },
                success:function(data){
                  if(data.code==0){
                     layer.msg(data.message, {icon: 1});
                     $('#creditsEdit').parent().find('span').text(credits_final);
                     setTimeout(function(){
                        layer.closeAll();
                     },500); 
                  }else{
                     layer.msg(data.message, {icon: 5});
                  }
                }
              });
     }
     @endif
</script>
@endsection