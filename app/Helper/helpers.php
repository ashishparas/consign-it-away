<?php // Code within app\Helpers\Helper.php

namespace App\Helper;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\API\ApiController;
use App\Models\Address;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Nikolag\Square\Facades\Square;
use Nikolag\Square\Models\customer;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shippo;
    // userId: 778CONSI5321
    // URL: https://stg-secure.shippingapis.com/ShippingAPI.dll?
class Helper extends ApiController
{
    // public $AccountId = "778CONSI5321";

    
    public static function shout(string $string)
    {
       
        return  $string;
    }


    public static function validateAddress($address_id=null){

        try{
            if($address_id !== null){
                $address = Address::where('id' , $address_id)->first();
                $fullName = $address->fname.' '.$address->lname;

                \Shippo::setApiKey(env('SHIPPO_PRIVATE'));   
                $toAddress = [
                    "name" => ucfirst($fullName), // required
                    "company" => "Consignitaway",
                    "street1"=> $address->address,  // required
                    "street2"=> "",
                    "city"=> $address->city,  //required
                    "state"=> $address->state, // required
                    "zip"=> $address->zipcode,  // required
                    "country"=> $address->country, // required
                    "phone"=> $address->mobile_no, // required
                    "email"=> $address->email, // required
                    "is_residential"=> true,
                    "metadata"=>"Customer ID". $address->user_id,
                   "validate" => true
        
                ];
                
             $address =  \Shippo_Address::create([
                    'name' => 'Shawn Ippotle',
                    "company" => "Consignitaway",
                    'street1' => '215 Clayton St.',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'zip' => '94117',
                    'country' => 'US',
                    "phone"=> "+9190678054", // required
                    "email"=> $address->email, // required
                    "validate" => true
             ]);
                // dd($address);
                if(!empty($address['validation_results'])):
                    $validate =   \Shippo_Address::validate($address['object_id']);
                   
                    return $address['validation_results']['is_valid'];    
                else:
                 return false;
                endif;
            }else{
                return false;
            }
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }

        
}


    // public static function CarierAccounts(){
        
    //     \Shippo::setApiKey(env('SHIPPO_PRIVATE'));
    //     $fedex_account = \Shippo_CarrierAccount::create(array(
    //         'carrier' => 'fedex',
    //         'account_id' => '510087780',
    //         'parameters' => array('first_name' => 'James', 'last_name' => 'Oddo', 'phone_number' => '+ 4177201199', 'from_address_st' => '1526 South Glenstone Ave', 'from_address_city' => 'Springfield', 'from_address_state' => 'MO', 'from_address_zip' => '65804', 'from_address_country_iso2' => 'United States'),
    //         'test' => true,
    //         'active' => true
    //     ));
    //     // $cr = \Shippo_CarrierAccount::all(array('carrier'=> ''));
    //     dd($fedex_account );
    // }


public static function shippingLabel($addressId, $productId){
        $customerAddress = Address::where('id', $addressId)->first();
        $storeAddress = Product::select('id','name','store_id','weight','dimensions')
        ->where('id', $productId)
        ->with('Store')
        ->first();
        // dd( $storeAddress->store->country);
        \Shippo::setApiKey(env('SHIPPO_PRIVATE'));
        $fromAddress = array(
            'name' => $storeAddress->store->name,
            'street1' => $storeAddress->store->address,
            'city' => $storeAddress->store->city,
            'state' => $storeAddress->store->state,
            'zip' => $storeAddress->store->zipcode,
            'country' => $storeAddress->store->country,
            'phone'   => $storeAddress->store->manager->mobile_no,
            'email'   => $storeAddress->store->manager->email

        );
      
        
        $toAddress = array(
            'name' =>  $customerAddress->fname.' '.$customerAddress->lname ,
            'street1' => $customerAddress->address,
            'city' => $customerAddress->city,
            'state' => $customerAddress->state,
            'zip' => $customerAddress->zipcode,
            'country' => $customerAddress->country,
            'phone' => $customerAddress->mobile_no
        );
       
        $dimensions = json_decode($storeAddress->dimensions, true);
    
        $parcel = array(
            'length'=> $dimensions? $dimensions['Length']:20,
            'width'=> $dimensions? $dimensions['Breadth']:20,
            'height'=> $dimensions? $dimensions['Height']:20,
            'distance_unit'=> 'in',
            'weight'=> $storeAddress->weight,
            'mass_unit'=> 'lb',
        );
      
        $shipment = \Shippo_Shipment::create( array(
            'address_from'=> $fromAddress,
            'address_to'=> $toAddress,
            'parcels'=> array($parcel),
            'async'=> false
            )
        );
        // dd($shipment);
        $rate = $shipment['rates'][7];

        $transaction = \Shippo_Transaction::create(array(
            'rate'=> $rate['object_id'],
            'async'=> false,
        ));
    
    // Print the shipping label from label_url
    // Get the tracking number from tracking_number
    if ($transaction['status'] == 'SUCCESS'){
        $result = [
            'tracking_no' => $transaction['tracking_number'],
            'shiping_label' => $transaction['label_url']
        ];
        return $result;
       
    } else {
        return parent::error($transaction['messages']);
        // echo "Transaction failed with messages:" . "\n";
        // foreach ($transaction['messages'] as $message) {
        //     echo "--> " . $message . "\n";
        // }
    }
           

            

}








public static function trackingStatus($trackingId){
    \Shippo::setApiKey(env('SHIPPO_PRIVATE'));
    $status_params = array(
        'id' => 'SHIPPO_TRANSIT',
        'carrier' => 'shippo'
    );
    
 
    $status = \Shippo_Track::get_status($status_params);

    $create_params = array(
        "carrier" => "shippo",
        "tracking_number"=> "SHIPPO_TRANSIT"
    );
    
    //The response is stored in $webhook response and is identical to the response of Track::get_status 
    $webhook_response = \Shippo_Track::create($create_params);
    
    
    echo "--> " . "Carrier: " . $webhook_response['carrier'] . "\n";
    echo "--> " . "Shipping tracking number: " . $webhook_response['tracking_number'] . "\n";
    echo "--> " . "Address from: " . $webhook_response['address_from'] . "\n";
    echo "--> " . "Address to: " . $webhook_response['address_to'] . "\n";
    echo "--> " . "Tracking Status: " . $webhook_response['tracking_status'] . "\n";
    exit;

}


    public static function ProductVariants($variants=[]){

        foreach($variants as $key => $variant){
            $option_id = explode(",",$variant['option_id']);
          // DB::enableQueryLog();
            $variants[$key]['variants'] = \App\Models\Attribute::select('attributes.id','attributes.name', DB::raw('attribute_options.id AS option_id, attribute_options.name AS option_name'))
            ->join("attribute_options","attributes.id","attribute_options.attr_id")
            ->whereIn('attribute_options.id', $option_id)
            ->with('Attributes')
            ->get();
        }
        return $variants;

    }
    
    public static function ProductSingleVariants($variant=null){

        // foreach($variants as $key => $variant){
            $option_id = explode(",",$variant['option_id']);
          // DB::enableQueryLog();
            $variants['variants'] = \App\Models\Attribute::select('attributes.id','attributes.name', DB::raw('attribute_options.id AS option_id, attribute_options.name AS option_name'))
            ->join("attribute_options","attributes.id","attribute_options.attr_id")
            ->whereIn('attribute_options.id', $option_id)
            ->with('Attributes')
            ->first();
        // }
        return $variant;

    }

    public static function ProductvariantById($variant_id=null){
        try{
            // Dev: Ashish Mehra
            $variants = Variant::where('id', $variant_id)->first();
            if($variants !==null){

               
                // dd($variants);
                $option_id = explode(",",$variants['option_id']);
              
                $selectedVariants = \App\Models\Attribute::select('attributes.id','attributes.name', DB::raw('attribute_options.id AS option_id, attribute_options.name AS option_name'))
                ->join("attribute_options","attributes.id","attribute_options.attr_id")
                ->whereIn('attribute_options.id', $option_id)
                ->with('Attributes')
                ->get();
                // dd($selectedVariants->toArray());
                return $selectedVariants;
            }else{
                return null;
            }
            
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public static function chargeCustomer($nonce_id=null){
       if($nonce_id !== null){
        $transaction = \Square::charge([
            'amount' => 500,
            'source_id' => $nonce_id,
            'location_id' => getenv('SQUARE_LOCATION'),
            'currency' => 'USD'
        ]);
        if($transaction['status'] === 'PAID'){
            echo true;
        }else{
            echo false;
        }
       }else{
        return false;
       }
        
        // dd();

    }


    public static function VerifyAddress(int $id=null){
        try{

        $address = Address::FindOrfail($id);
   
        if($address):

    $input_xml = <<<EOXML
                        <AddressValidateRequest USERID="641IHERB6005">
                            <Address ID="$address->id">
                                <Address1></Address1>
                                <Address2>$address->address</Address2>
                                <City>$address->city</City>
                                <State>$address->state</State>
                                <Zip5>$address->zipcode</Zip5>
                                <Zip4></Zip4>
                            </Address>
                        </AddressValidateRequest>
                EOXML;
            
            $fields = array('API' => 'Verify','XML' => $input_xml);
            
            $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            
            // Convert the XML result into array
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
          // dd($array_data  );
                    if(array_key_exists('Error', $array_data['Address'])):
                            return false;
                        else:
                            return true;
                    endif;     
        endif;
        }catch(\Exception $ex){
            return false;
        }
    }


    public static function UPSP($data, $product_id , int $address_id=null, int $vendor_id, int $store_id=null){
    
        try{
            $store = Store::FindOrfail($store_id);
            $user = User::FindOrfail($vendor_id);
          
            $cusName = Auth::user()->name;
            $cusMobileNo = Auth::user()->mobile_no;
            $cusEmail = Auth::user()->email;
            $address = Address::FindOrfail($address_id);
            $name = ($user->name !== '')?$user->name:'No-Name';
            $product = Product::FindOrfail($product_id);
            if($address_id != null && $vendor_id != null && $store_id !=null){

$input_xml = <<<EOXML

                        <eVSRequest USERID= "641IHERB6005">
                        <Option/>
                        <Revision/>
                        <ImageParameters>
                        <LabelSequence>
                        <PackageNumber>1</PackageNumber>
                        <TotalPackages>$data->quantity</TotalPackages>
                        </LabelSequence>
                        </ImageParameters>
                        <FromName>$name</FromName>
                        <FromFirm>$store->name</FromFirm>
                        <FromAddress1>Apt 303</FromAddress1>
                        <FromAddress2>1309 S Agnew Avenue</FromAddress2>
                        <FromCity>Oklahoma City</FromCity>
                        <FromState>OK</FromState>
                        <FromZip5>73108</FromZip5>
                        <FromZip4>2427</FromZip4>
                        <FromPhone>$user->mobile_no</FromPhone>
                        <POZipCode/>
                        <AllowNonCleansedOriginAddr>false</AllowNonCleansedOriginAddr>
                        <ToName>$cusName</ToName>
                        <ToFirm>ABC Corp.</ToFirm>
                        <ToAddress1/>
                        <ToAddress2>$address->address</ToAddress2>
                        <ToCity>$address->city</ToCity>
                        <ToState>$address->state</ToState>
                        <ToZip5>$address->zipcode</ToZip5>
                        <ToZip4></ToZip4>
                        <ToPhone>$cusMobileNo</ToPhone>
                        <POBox/>
                        <ToContactPreference>EMAIL</ToContactPreference>
                        <ToContactMessaging/>
                        <ToContactEMail>$cusEmail</ToContactEMail>
                        <AllowNonCleansedDestAddr>false</AllowNonCleansedDestAddr>
                        <WeightInOunces>$product->weight</WeightInOunces>
                        <ServiceType>PRIORITY</ServiceType>
                        <Container>VARIABLE</Container>
                        <Width>5.5</Width>
                        <Length>11</Length>
                        <Height>11</Height>
                        <Machinable>TRUE</Machinable>
                        <ProcessingCategory/>
                        <PriceOptions/>
                        <AddressServiceRequested>true</AddressServiceRequested>
                        <ExpressMailOptions>
                        <DeliveryOption/>
                        <WaiverOfSignature/>
                        </ExpressMailOptions>
                        <ShipDate></ShipDate>
                        <CustomerRefNo>EF789UJK</CustomerRefNo>
                        <CustomerRefNo2>EE66GG87</CustomerRefNo2>
                        <ExtraServices>
                        <ExtraService>120</ExtraService>
                        </ExtraServices>
                        <HoldForPickup/>
                        <OpenDistribute/>
                        <PermitNumber/>
                        <PermitZIPCode/>
                        <PermitHolderName/>
                        <VendorCode>$product->id</VendorCode>
                        <VendorProductVersionNumber>5.02.1B</VendorProductVersionNumber>
                        <SenderName>Adam Johnson</SenderName>
                        <SenderEMail>$user->email</SenderEMail>
                        <RecipientName>$cusName</RecipientName>
                        <RecipientEMail>$cusEmail</RecipientEMail>
                        <ReceiptOption>SAME PAGE</ReceiptOption>
                        <ImageType>PDF</ImageType>
                        <ShipInfo>True</ShipInfo>
                        <DropOffTime/>
                        <ReturnCommitments>True</ReturnCommitments>
                        <PrintCustomerRefNo>False</PrintCustomerRefNo>
                        <PrintCustomerRefNo2>True</PrintCustomerRefNo2>
                        <Content>
                        <ContentType>Perishable</ContentType>
                        </Content>
                        <ActionCode>M0</ActionCode>
                        <OptOutOfSPE>false</OptOutOfSPE>
                        <SortationLevel/>
                        <DestinationEntryFacilityType/>
                        </eVSRequest>

            EOXML;
            
            $fields = array('API' => 'eVS','XML' => $input_xml);
            
            $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            
            // Convert the XML result into array
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
        
            return $array_data['BarcodeNumber'];

            }else{
                return false;
            }
            

        }catch(\Exception $ex){
            return false;
        }

    }





    public static function trackCourier($tracking_id){
        try{

        if($tracking_id !== null){

                    $input_xml = <<<EOXML
                                    <TrackRequest USERID="778CONSI5321">
                                        <TrackID ID="$tracking_id"></TrackID>
                                    </TrackRequest>
                                EOXML;
            
                $fields = array('API' => 'TrackV2','XML' => $input_xml);
            
                $url = 'https://secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
                        $data = curl_exec($ch);
                        curl_close($ch);
            // Convert the XML result into array
                        $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
                        $arr = [];
                        $newString="";
            // dd($array_data);
            if(isset($array_data['TrackInfo']['TrackDetail'])){
                foreach($array_data['TrackInfo']['TrackDetail'] as $key => $track):
        
                    $extract_date_pattern = "/(January|February|March|April|May|June|July|Augest|September|October|November|December)\s\d{2},\s{1}\d{4}/";
                        $string_to_match = $track;
                            if ( preg_match_all($extract_date_pattern, $string_to_match, $matches) ) {
                                
                                $newdate =  date('m/d/Y',strtotime($matches[0][0]));
                                $newString = str_replace($matches[0][0],  $newdate,  $string_to_match);
                                //   echo $newString."<br>"; 
                                $string_to_match = $newString;
                            }
                            $arr[] = explode(",", $string_to_match);
                            //$keys  = array('status','date','time','address','zip');
                            $av = [];
                            foreach( $arr as $key => $value){
                                //for($i=0; $i<count($value); $i++ ){
                                  $av[$key]['status'] = $value[0];
                                  $av[$key]['date'] = $value[1];
                                  $av[$key]['time'] = (isset($value[2]))? $value[2]:"";
                                  $av[$key]['address'] = (isset($value[3]))? $value[3]:"";
                                  $av[$key]['zip'] = (isset($value[4]))? $value[4]:""; 
                            }
                           
                            // }
                endforeach;
                        // dd($arr);
                    return array('status'=>true,'data'=> $av);
            }else{
                $uspsErrorData = isset($array_data['TrackInfo']['Error']) ? 
                                    $array_data['TrackInfo']['Error']['Description']:
                                    $array_data['TrackInfo']['TrackSummary'];
               return array('status'=>false,'data'=> $uspsErrorData);
            }



        }

        }catch(\Exception $ex){
            return false;
        }
    }


    public static function getShippingPrice(){
        try{

    $input_xml = <<<EOXML
                    <RateV4Request USERID="641IHERB6005">
                    <Revision>2</Revision>
                    <Package ID="0">
                    <Service>PRIORITY</Service>
                    <ZipOrigination>22201</ZipOrigination>
                    <ZipDestination>26301</ZipDestination>
                    <Pounds>8</Pounds>
                    <Ounces>2</Ounces>
                    <Container></Container>
                    <Width></Width>
                    <Length></Length>
                    <Height></Height>
                    <Girth></Girth>
                    <Machinable>TRUE</Machinable>
                    </Package>
                    </RateV4Request>
                EOXML;
            
            $fields = array('API' => 'RateV4','XML' => $input_xml);
            
            $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
        
            return json_decode(json_encode(simplexml_load_string($data)), true);
         
                    
        }catch(\Exception $ex){
            return false;
        }
    }


    public static function ReturnRequest(){
        try{

            $input_xml = <<<EOXML
                            <USPSReturnsLabelRequest USERID="641IHERB6005">
                            <Option/>
                            <Revision></Revision>
                            <ImageParameters>
                            <ImageType>PDF</ImageType>
                            <SeparateReceiptPage>false</SeparateReceiptPage>
                            </ImageParameters>
                            <CustomerFirstName>Ashish</CustomerFirstName>
                            <CustomerLastName>Mehra</CustomerLastName>
                            <CustomerFirm>Abc </CustomerFirm>
                            <CustomerAddress1/>
                            <CustomerAddress2>PO Box 100</CustomerAddress2>
                            <CustomerUrbanization/>
                            <CustomerCity>Washington</CustomerCity>
                            <CustomerState>DC</CustomerState>
                            <CustomerZip5>20260</CustomerZip5>
                            <CustomerZip4>1122</CustomerZip4>
                            <POZipCode>20260</POZipCode>
                            <AllowNonCleansedOriginAddr>false</AllowNonCleansedOriginAddr>
                            <RetailerATTN>ATTN: Retailer Returns Department</RetailerATTN>
                            <RetailerFirm>Retailer Firm</RetailerFirm>
                            USPS Web Tools User Guide
                            15
                            <WeightInOunces>80</WeightInOunces>
                            <ServiceType>PRIORITY</ServiceType>
                            <Width>4</Width>
                            <Length>10</Length>
                            <Height>7</Height>
                            <Girth>2</Girth>
                            <Machinable>true</Machinable>
                            <CustomerRefNo>RMA%23: EE66GG87</CustomerRefNo>
                            <PrintCustomerRefNo>true</PrintCustomerRefNo>
                            <CustomerRefNo2> EF789UJK </CustomerRefNo2>
                            <PrintCustomerRefNo2>true</PrintCustomerRefNo2>
                            <SenderName>Sender Name for Email</SenderName>
                            <SenderEmail>senderemail@email.com</SenderEmail>
                            <RecipientName>Recipient of Email</RecipientName>
                            <RecipientEmail>recipientemail@email.com</RecipientEmail>
                            <TrackingEmailPDF>true</TrackingEmailPDF>
                            <ExtraServices>
                            <ExtraService>156</ExtraService>
                            </ExtraServices>
                            </USPSReturnsLabelRequest>
                EOXML;
            
            $fields = array('API' => 'USPSReturnsLabel','XML' => $input_xml);
            
            $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode(json_encode(simplexml_load_string($data)), true);
            dd($data);

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }




    public static function SchedulePickup(){
        try{

            $input_xml = <<<EOXML
                            <CarrierPickupScheduleRequest USERID="641IHERB6005">
                            <FirstName>John</FirstName>
                            <LastName>Doe</LastName>
                            <FirmName>ABC Corp.</FirmName>
                            <SuiteOrApt>Suite 777</SuiteOrApt>
                            <Address2>8 Wildwood Drive</Address2>
                            <Urbanization></Urbanization>
                            <City>Old Lyme</City>
                            <State>CT</State>
                            <ZIP5>06371</ZIP5>
                            <ZIP4>1234</ZIP4>
                            <Phone>9068768054</Phone>
                            <Extension>201</Extension>
                            <Package>
                            <ServiceType>PriorityMailExpress</ServiceType>
                            <Count>2</Count>
                            </Package>
                            <Package>
                            <ServiceType>PriorityMail</ServiceType>
                            <Count>1</Count>
                            </Package>
                            <EstimatedWeight>14</EstimatedWeight>
                            <PackageLocation>Front Door</PackageLocation>
                            <SpecialInstructions>Packages are behind the screen door.</SpecialInstructions>
                            </CarrierPickupScheduleRequest>
                        EOXML;
                    
                    $fields = array('API' => 'CarrierPickupSchedule','XML' => $input_xml);
                    
                    $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
                    $data = curl_exec($ch);
                    curl_close($ch);
                
                    return json_decode(json_encode(simplexml_load_string($data)), true);
                 
                            
                }catch(\Exception $ex){
                    return false;
                }
    }






    public static function SendVarificationEmail($email, $name, $message){

        $sendGridMail = new \SendGrid\Mail\Mail();
        $sendGridMail->setFrom(getenv('MAIL_ADDRESS'), "ConsignItAway");
        $sendGridMail->setSubject("OTP Verification Mail");
        $sendGridMail->addTo($email, $name);
        $sendGridMail->addContent("text/plain", "OTP Verification Mail");
        $sendGridMail->addContent("text/html",$message);
        
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $response = $sendgrid->send($sendGridMail);
        return true;
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
        // exit;
    }















    
}

