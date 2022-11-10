$(document).ready(function()
{
  

    var token = $('meta[name="csrf-token"]').attr('content'); 
    $('#ptable').DataTable({
        processing: true,
        serverSide: true,
        columnDefs:[
        {
         visible:true,
        }
    ],      
        ajax: {
            url: base_path+"ajaxForm"+'?_token='+token,
            type: 'POST',               
        },
        columns: [
            {data: 'DT_RowIndex',name : 'Id'},         
            {data: 'name' ,name : 'name'},
            {data: 'sku' ,name : 'sku'},
            {data: 'price' ,name : 'price'},
            {data: 'image' ,name : 'image'},
            {data: 'status' ,name : 'status'},
            {data: 'Actions',name : 'Actions', responsivePriority: -1},
        ],
       buttons: [
            {
                text: 'Add new button',
                action: function ( e, dt, node, config ) {
                    dt.button().add( 1, {
                        text: 'Button '+(counter++),
                        action: function () {
                            this.remove();
                        }
                    } );
                }
            }
        ]

    });

$("#addForm" ).on("submit", function(event) {
    event.preventDefault();
   // var form = $('#addForm')[0];
    var formData = new FormData(this);
    $.ajax({
        type: "post",
       dataType: "json",
       url: base_path+"addProduct",
      // data: $(form).serialize(),
      data: formData,
      cache: false,
        contentType: false,
        processData: false,
       success: function (response) {
        
           if(response.status == true)
           {
            alert(response.msg);
            $(location).attr('href', base_path+'home');   
               
           }
           else  if(response.status == false)
           {
  
            alert(response.msg);
           }
          
       }
   });
    
  });


 // $(".delete").on("click", function(event) {
    $(document).on('click', '.delete' ,function(event) {
    event.preventDefault(); 
    if($(this).data('id') !="")
    {
        var id =$(this).data('id');
        $.ajax({
            type: "post",
           dataType: "json",
           url: base_path+"deleteProduct"+'?_token='+token,
           data: {id:id},
           success: function (response) {
            
               if(response.status == true)
               {
                alert(response.msg);
                $(location).attr('href', base_path+'home');   
                   
               }
               else  if(response.status == false)
               {
      
                alert(response.msg);
               }
              
           }
       });
    }
});

});