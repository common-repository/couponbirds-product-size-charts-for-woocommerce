jQuery(document).ready(function($) {
    //table编辑
    let show_table = $('#cb-modal-show-tab');
    let show_modal = $('#cb-size-chart-modal');
    let show_modal_overly = $('#cb-size-chart-modal-overly');
    let show_button = $('.cb-show-modal-button');
    let show_link = $('#cb-link-show-div');
    show_button.on('click',function (){
        draw_table($(this));
        show_modal.show();
    });
    show_modal_overly.on('click',function (){
        show_modal.hide();
    });
    function draw_table(arg){
        let tab = arg.attr('data-tab');
        let style = arg.attr('data-style');
        let link_show = arg.attr('data-link-show');
        if (!tab){
            tab='[[""]]';
        }
        if (!style){
            style='default';
        }
        let data = JSON.parse(tab);
        show_table.empty();
        let tb = '';
        for (let i=0;i<data.length;i++){
            tb += '<tr>';
            for (let j=0;j<data[i].length;j++){
                tb+='<td>'+data[i][j]+'</td>';
            }
            tb+='</tr>';
        }
        show_table.append(tb);
        show_table.attr('class','cb-size-chart-style-'+style);
        show_link.empty();
        if (link_show){
            show_link.append('<p class="cb-link-show-p">Power By <a target="_blank" href="https://www.couponbirds.com/size-charts">CouponBirds</a></p>');
        }
    }
});