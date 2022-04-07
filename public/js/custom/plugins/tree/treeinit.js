if(typeof tree != 'undefined') {
    var data = tree;

    $('#js-tree').jstree({
        'core': {
            'data': data,
            'check_callback': false,
            'animation': 1
        },
        'plugins' : [
            'dnd', 'wholerow'
        ]
    });

}
$('#js-tree').on('click', '.jstree-anchor', function () {

    // alert(this.id);
    var id=this.id.substring(0, 36);
    // alert(id)
    if(typeof userByTree === 'function'){
        userByTree(id);
    }
   // var id = data.node.id;

  //  var text = data.node.text;

    page = 1;

    loadMore = false;


    $('#staff-table-search').data('structure', id);
   // $('#staff-table-search').data('name', text);

    $.ajax({
        url: '/staff-table',
        type: 'GET',
        data: {structureId: id},
        success: function (response) {

            if (parseInt(response.code) === 200) {

                $('#staff-table-paginate').data('total', response.totalCount);

                $('.count').text(response.totals.data.totalCountOwn);
                $('.salary').text(response.totals.data.totalSalaryOwn);

                $('.total-count').text(response.totals.data.totalCount);
                $('.total-salary').text(response.totals.data.totalSalary);

                $('#positionNameTBody').html(loadTable(response.data));

            }

        }
    });

})

// $('body').on("select_node.jstree", '#js-tree', function (e, data) {
//     var id = data.node.id;
//      alert(id)
//     if(typeof userByTree === 'function'){
//         userByTree(id);
//     }
//     // userByTree(id);
// }).bind('ready.jstree', function (event, data) {
//     $("#js-tree").jstree('open_node', 'C104DE19-BA37-E711-A819-005056B83045', function(e,d){});
// });

$('body').on('click', '.jstree-anchor', function () {


    var str=$(this).attr('id').substring(1, 36);

});

$('#js-tree').on("select_node.jstree", function (e, data) {
    var id = data.node.id;
    //   alert(id)
    // if(typeof userByTree === 'function'){
    //     userByTree(id);
    // }
    // userByTree(id);
}).bind('ready.jstree', function (event, data) {
    $("#js-tree").jstree('open_node', 'C104DE19-BA37-E711-A819-005056B83045', function(e,d){});
});

$('body').on('click', '#archive', function () {


    $.ajax({

        type: 'GET',

        url: '/staff-table/treea',

        success: function (response) {

            console.log(response);

            response.forEach(function(element, index, array){

                if(response[index].isClosed==true){

                    response[index].text='<span style="color:red">'+response[index].text+'</span>';
                }

            });

            $('#js-tree').jstree("destroy");


            $('#js-tree').jstree({
                'core': {
                    'data': response,
                    'check_callback': true,
                    'animation': 1
                },
                'plugins' : [
                    'dnd', 'wholerow'
                ]
            }).on("select_node.jstree", function (e, data) {
                var id = data.node.id;


            }).bind('ready.jstree', function (event, data) {

                $("#js-tree").jstree('open_node', 'C104DE19-BA37-E711-A819-005056B83045', function(e,d){});
            });


        }
    });

})


$('body').on('click', '#current', function () {

    $.ajax({

        type: 'GET',

        url: '/staff-table/tree',

        success: function (response) {


            $('#js-tree').jstree("destroy");

            $('#js-tree').jstree({
                'core': {
                    'data': response,
                    'check_callback': true,
                    'animation': 1
                },
                'plugins' : [
                    'dnd', 'wholerow'
                ]
            }).on("select_node.jstree", function (e, data) {
                var id = data.node.id;
                updateTree();
            }).bind('ready.jstree', function (event, data) {
                $("#js-tree").jstree('open_node', 'C104DE19-BA37-E711-A819-005056B83045', function(e,d){});
            });


        }
    });

})