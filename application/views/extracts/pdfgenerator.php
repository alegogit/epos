<img src="<?=base_url()."assets/img/testinv1.jpg"?>">

<script>   
  $(document).ready(function(){
  
  function step1(){ 
  
    $.ajax({
      type: "POST",
      url: baseurl+"process/tableorder?p=delete",
      data: dataP,
      cache: false,
      success: function(result){
        if(result.trim()!='OK'){
          alert(result);
        } else {
          $this.parents('tr').fadeOut(function(){
            $this.remove(); //remove row when animation is finished
          });
          var page = window.location.href;
          window.location.assign(page);
        }
      }
    });
    
  }
  
  });
</script>            