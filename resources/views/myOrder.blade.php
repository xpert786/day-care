<h4>I want to pay 768 USD</h4>
<form method="post" action="{!! URL::to('paypal') !!}" >
    @csrf
   <input type="hidden" name="amount" value="768"> 
   <input type="submit" name="paynow" value="Pay Now">
</form>