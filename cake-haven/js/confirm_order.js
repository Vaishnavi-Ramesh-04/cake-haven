document.addEventListener('DOMContentLoaded', function(){
  const modal = document.getElementById('confirm-modal');
  const btn = document.getElementById('confirm-order');
  const cancel = document.getElementById('cancel-confirm');
  const form = document.getElementById('confirm-form');

  if(!modal || !btn || !form) return;

  function show(){ modal.style.display='block'; }
  function hide(){ modal.style.display='none'; }

  btn.addEventListener('click', show);
  cancel.addEventListener('click', hide);

  form.addEventListener('submit', function(e){
    e.preventDefault();
    const data = new FormData(form);
    data.append('pay_on_delivery', '1');

    fetch('process_order.php', {
      method: 'POST',
      body: data
    }).then(r=>r.json()).then(resp=>{
      if(resp && resp.ok && resp.orderId){
        hide();
        alert('Order placed successfully. Thank you!');
        window.location.href = 'order_confirmation.php?id=' + resp.orderId;
      } else if(resp && resp.error){
        alert('Error: ' + resp.error);
      } else {
        alert('Unexpected response from server');
      }
    }).catch(err=>{
      console.error(err); alert('Failed to place order');
    });
  });
});
