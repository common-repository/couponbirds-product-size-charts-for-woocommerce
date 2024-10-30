jQuery(document).ready(function($) {
    //table编辑
    let table = $('#cb-size-chart-table');
    let preview_table = $('#cb-size-chart-preview');
    let input_hidden = $('#cb-table-data');
    let data = JSON.parse(input_hidden.val());
    draw_table();
    table.on('click','button.cb-chart-table-control',function (){
        let index = parseInt($(this).attr('data-index'));
        let temp = $(this).attr('class').split(' ')[1];
        let a = [];
        if (temp === 'cb-add-col') {
            for (let i = 0; i < data.length; i++) {
                let b = [];
                for (let j = 0; j < data[i].length; j++) {
                    b.push(data[i][j]);
                    if (j === index) {
                        b.push("");
                    }
                }
                a.push(b);
            }
        }else if (temp === 'cb-del-col'){
            if (data[0].length<2){
                return;
            }
            for (let i = 0; i < data.length; i++) {
                let b = [];
                for (let j = 0; j < data[i].length; j++) {
                    if (j !== index) {
                        b.push(data[i][j]);
                    }
                }
                a.push(b);
            }
        }else if (temp === 'cb-add-row'){
            for (let i = 0; i < data.length; i++) {
                a.push(data[i]);
                if (i === index) {
                    let b = [];
                    for (let j = 0; j < data[i].length; j++) {
                        b.push("");
                    }
                    a.push(b);
                }
            }
        }else if (temp === 'cb-del-row'){
            if (data.length<2){
                return;
            }
            for (let i = 0; i < data.length; i++) {
                if (i !== index) {
                    a.push(data[i]);
                }
            }
        }else {
            return
        }
        data = a;
        input_hidden.val(JSON.stringify(data));
        draw_table();
    });
    table.on('input','input.cd-size-chart-item',function (){
        let item=$(this);
        let i = parseInt(item.attr('data-i'));
        let j = parseInt(item.attr('data-j'));
        data[i][j] = item.val().replace(/"/g,'&quot;');
        input_hidden.val(JSON.stringify(data));
        draw_preview_table();
    });
    function draw_table(){
        table.empty();
        preview_table.empty();
        let th = "<tr>";
        for (let i=0;i<data[0].length;i++){
            th+='<td><button type="button" class="cb-chart-table-control cb-add-col" data-index="'+i+'">+</button>'+
                '<button type="button" class="cb-chart-table-control cb-del-col" data-index="'+i+'">-</button></td>'
        }
        th += '<td></td></tr>';
        let tb = '';
        let tb1 = '';
        for (let i=0;i<data.length;i++){
            tb += '<tr>';
            tb1 += '<tr>';
            for (let j=0;j<data[i].length;j++){
                tb+='<td><label><input  style="width: 100%"  class="cd-size-chart-item" data-i="'+i+'" data-j="'+j+'" type="text" value="'+data[i][j]+'"/></label></td>';
                tb1+='<td>'+data[i][j]+'</td>';
            }
            tb+='<td><button type="button" class="cb-chart-table-control cb-add-row" data-index="'+i+'">+</button>'+
                '<button type="button" class="cb-chart-table-control cb-del-row" data-index="'+i+'">-</button></td></tr>'
        }
        table.append(th+tb);
        preview_table.append(tb1);
    }
    function draw_preview_table(){
        preview_table.empty();
        let tb1 = '';
        for (let i=0;i<data.length;i++){
            tb1 += '<tr>';
            for (let j=0;j<data[i].length;j++){
                tb1+='<td>'+data[i][j]+'</td>';
            }
        }
        preview_table.append(tb1);
    }
    //products编辑
    $('#cb-product-select').select2({
        width: '100%',
    });
    //categories编辑
    $('#cb-category-select').select2({
        width: '100%',
    });
    //style选择
    let input_hidden_style = $('#cb-table-style');
    let style_select = $('#cb-table-style-select');
    let style = input_hidden_style.val();
    style_select.val(style);
    preview_table.attr('class','cb-size-chart-style-'+style);
    style_select.on('change',function (){
        let temp=$(this).val();
        input_hidden_style.val(temp);
        preview_table.attr('class','cb-size-chart-style-'+temp);
    });
    //模版选择
    $('#cb-chart-template-select').on('change',function (){
        input_hidden.val($(this).val());
        data = JSON.parse(input_hidden.val());
        draw_table();
    });
    //外链
    let input_hidden_link = $('#cb-link-show');
    let link_show_checkbox = $('#cb-link-show-checkbox');
    if (input_hidden_link.val()){
        link_show_checkbox.prop('checked',true);
    }
    link_show_checkbox.on('click',function (){
        input_hidden_link.val($(this).prop('checked')?'1':'');
    });
    //位置信息选中
    $('#cb-chart-position-select').val($('#cb-position-data').val());
});