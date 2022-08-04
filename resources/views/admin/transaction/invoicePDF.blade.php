<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Consign</title>

</head>
<body>
 <div style="width:100%; font-family: Arial, Helvetica, sans-serif;">
    <div>
        <h2>Invoice Details</h2>
        <div style="font-size:17px; font-weight:600; color:#4A4A4A; border-bottom: 1px solid #ccc; padding-bottom: 7px; margin-bottom: 11px;">
            Invoice No: #{{ $transaction->id }}
            <span style="float:right; color:#858585; font-weight: 300; font-size: 13px;">Date: {{ date('d-m-Y',strtotime($transaction->created_at)) }}</span>
        </div>
    </div>
    <table class="table" style="width:49%; float: left; border-right: 1px solid #ccc; padding-right: 10px;">
        <tbody>
          <tr>
            <td colspan="2" style="color:#000; padding-bottom: 5px; font-weight: 700;">Bill To:</td>
          </tr>
          <tr>
            <td colspan="2" style="font-size:20px; color:#48BF91; font-weight:600; padding-bottom: 5px; ">{{ $transaction->item->address->fname }}  {{ $transaction->item->address->lname }}</td>
          </tr>
          <tr>
            <td colspan="2" style="font-size:14px; border-bottom: 1px solid #ccc; padding-bottom:10px;"> {{ $transaction->item->address->address }} {{ $transaction->item->address->city }} {{ $transaction->item->address->state }} {{ $transaction->item->address->zipcode }}</td>
          </tr>
          <tr>
            <td style="width:100%;">
                <table class="table" style="width:100%; margin-top: 10px;">
                    <tbody>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom: 12px; font-size: 15px;">Fax No:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 14px;">-</td>
                      </tr>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom: 12px; font-size: 15px;">Contact:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 14px;">{{ $transaction->item->address->phonecode }} {{ $transaction->item->address->mobile_no }}</td>
                      </tr>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom:  12px; font-size: 15px;">Email:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 14px;">{{ $transaction->item->address->email }}</td>
                      </tr>
                      
                      <tr>
                        <td colspan="2" style="border-bottom: 1px solid #ccc; padding-bottom:11px;"><button type="button" style="background: #DAF2E9;  border: 0px; padding: 6px;font-size: 12px;
                            color: #48BF91;  font-weight: 700;">{{ ($transaction->payment_status == '1')? 'Success':'Pending Or Failed' }}</button>
                        </td>
                      </tr>
                      
                      </tbody>
                      </table>
            </td>
          </tr>
      
        </tbody>
      </table>

      <table class="table" style="width:50%; float: right;">
        <tbody>
          <tr>
            <td colspan="2" style="color:#000; padding-bottom: 5px; font-weight: 700;">Bill From:</td>
          </tr>
          <tr>
            <td colspan="2" style="font-size:20px; color:#48BF91; font-weight:600; padding-bottom: 5px;">{{ $transaction->vendor->name }}</td>
          </tr>
          <tr>

            <td colspan="2" style="font-size:14px; border-bottom: 1px solid #ccc; padding-bottom:10px;"> {{ ($transaction->product)?$transaction->product->store->location:'-'}}</td>
          </tr>
          <tr>
            <td style="width:100%;">
                <table class="table" style="width:100%; margin-top: 10px;">
                    <tbody>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom: 12px; font-size: 14px;">Fax No:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px;">{{ $transaction->vendor->fax }}</td>
                      </tr>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom: 12px; font-size: 14px;">Role Manager:  </td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px;">{{ ($transaction->product->store->manager)?$transaction->product->store->manager->name :'-' }}</td>
                      </tr>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom:  12px; font-size: 14px;">Manager Contact:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px;">{{ ($transaction->product->store->manager)?$transaction->product->store->manager->phonecode :'' }} - {{ ($transaction->product->store->manager)?$transaction->product->store->manager->mobile_no:'' }}</td>
                      </tr>
                      
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom:  12px; font-size: 14px; border-bottom: 1px solid #ccc; padding-bottom:25px;">Transaction ID:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px;  border-bottom: 1px solid #ccc; padding-bottom:25px">#{{ $transaction->transaction_id }}</td>
                      </tr>
                      <tr>
                        <td style="color:rgb(99, 96, 96); padding-bottom:  12px; font-size: 14px; padding-top: 10px;">Payment Status:</td>
                        <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px; padding-top: 10px;">{{ ($transaction->payment_status == '1')? 'Paid':'Pending Or Failed' }}</td>
                      </tr>
                     
                      </tbody>
                      </table>
            </td>
          </tr>
       
        </tbody>
      </table>
   
        
        <table class="table" style="width:100%; margin-top: 10px;clear: both;">
          <tbody>
            <tr>
            <td colspan="2" style="background-color:#F0F0F0; font-size:17px; padding: 10px;">Receipt</td>
          </tr>
            <tr>
              <td style="color:rgb(99, 96, 96); padding-bottom: 12px; font-size: 14px;">Total Amount</td>
              <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px; color: #48BF91 !important;">$ {{ $transaction->price }} </td>
            </tr>
            <tr>
              <td style="color:rgb(99, 96, 96); padding-bottom:  12px; font-size: 14px;">Consignment(%)- 3%</td>
              <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px; color: #48BF91 !important;">- $ 0.00</td>
            </tr>
            <tr>
              <td style="color:rgb(99, 96, 96); padding-bottom:  12px; font-size: 14px;">Paid Amount</td>
              <td style="color:#000; padding-bottom: 5px; text-align: right; font-size: 13px; color: #48BF91 !important;">$ {{ $transaction->price }} </td>
            </tr>
            </tr>
            </tbody>
            </table>
    
 </div>
</body>
</html>
