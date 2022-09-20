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
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shippo;
    // userId: 778CONSI5321
    // URL: https://stg-secure.shippingapis.com/ShippingAPI.dll?
class Helper extends ApiController
{
    // public $AccountId = "778CONSI5321";

    public function __construct()
    {
        $this->fedExAc = "740561073";
    }
    public static function shout(string $string)
    {
        
        return  $string;
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
            return true;
        }else{
            return false;
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

    public static function zipCodeLookup($zipcode){
        try{

            $input_xml = <<<EOXML
                        <CityStateLookupRequest USERID="641IHERB6005">
                        <ZipCode ID='0'>
                        <Zip5>$zipcode</Zip5>
                        </ZipCode>
                        </CityStateLookupRequest>
                EOXML;
            
            $fields = array('API' => 'CityStateLookup','XML' => $input_xml);
            
            $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            
            // Convert the XML result into array
            
           $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
        //    dd($array_data['ZipCode']);
        if(isset($array_data['ZipCode']['Error'])){
            // dd($array_data['ZipCode']['Error']);
           return array('status'=> false,'message' => $array_data['ZipCode']['Error']['Description']);
        }else{
           return array('status'=> true,'message' => 'zipcode available');
        }
            
            return $array_data;
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public static function UPSP($data, $product_id , int $address_id=null, int $vendor_id, int $store_id=null, $product_details){
      
        try{
         
            $length = $product_details['length'];
            $width = $product_details['width'];
            $height = $product_details['height'];
            $pound = $product_details['pound'];
          
            $store = Store::FindOrfail($store_id);
           
            $user = User::FindOrfail($data->user_id);
           
            $customerRefNo = base64_encode($data->user_id);
       
            $cusName = $user->name;
         
            $cusMobileNo = $user->mobile_no;
            
            $cusEmail = $user->email;
          
            $address = Address::FindOrfail($address_id);
         
            $name = (Auth::user()->fname !== '')? Auth::user()->name: 'No-Name';
           
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
                        <WeightInOunces>$pound</WeightInOunces>
                        <ServiceType>PRIORITY</ServiceType>
                        <Container>VARIABLE</Container>
                        <Width>$width</Width>
                        <Length>$length</Length>
                        <Height>$height </Height>
                        <Machinable>TRUE</Machinable>
                        <ProcessingCategory/>
                        <PriceOptions/>
                        <AddressServiceRequested>true</AddressServiceRequested>
                        <ExpressMailOptions>
                        <DeliveryOption/>
                        <WaiverOfSignature/>
                        </ExpressMailOptions>
                        <ShipDate></ShipDate>
                        <CustomerRefNo>$customerRefNo</CustomerRefNo>
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
          
                    $pdf_decoded = base64_decode ($array_data['LabelImage']);
                    $fileName = 'shipping_label/'.time().rand(1111,9999).'-'.date('Y-m-d').'-label.pdf';

                    $pdf = fopen ($fileName,'w');
                    fwrite ($pdf,$pdf_decoded);
               
            return  array('print_label' => $fileName,'tracking_id'=> $array_data['BarcodeNumber'] ,'BaseUrl'=> asset(''));
   
            }else{
            
                return false;
            }
            

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }

    }

    public static function AuthenticateFedExUser(){
        

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://apis-sandbox.fedex.com/oauth/token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=l7cd240451e0aa437b86597dd87a3ec3b5&client_secret=0e85f92c25864fca846bab1dd5890854',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Cookie: _abck=CE1C42A2FE122BA7F0080A11B1927269~-1~YAAQhKg7F8AWGPSCAQAAdVETHAiW2yzoKMjBIFNF2wCFpaQMlXOtTl3rVtaBXjJP+ajRX9DNZ/fCHfc+8crJ5zYXwGcs46hdSxHh6JXwGJnWryFbUBb+ZMEbb0ZHnvKySC5/eNPZVoMlcM2XluOjcfi5xgenlK2hlX399La52DDHwhjmTaTc5cbIc2/tjMo6xZ8VKmDhz/Zj2QC9MNNe/6m1wRwyGQ+2Qsz2czRe1KKWBrOQQ+4gBaRUq2PqqofCzNqegVObeEOYKy8dWrW6zFEuPGJA3No0ukeC1Hf86QYfBkZqPoTfuCNVeg2yveLP2mLO+x+QvnipWeBiz/k7zWLw5BUIwmwS6PmRo5GV3GdnEzAhxjqYe8Aq0aDnN2QpzTM3zV3H~-1~-1~-1; ak_bmsc=B552D78874D1AEA9477B2EDE52F26916~000000000000000000000000000000~YAAQrPTfFyHIvv2CAQAAphR9HBG6T1nFu7BWUe8EUJ1cZ1iMuYjvleSea2xArsD2Mw5/gUPbIyaB9oynoElsSJ/lWFZ2BMjXlZQSwVFVAHEdYpKI9unPeoAuGVSR97329wC/Rz//SMKRAp1+CXXxMdwxaJY//DPk+Oqz1DDfEaDSmK7eVBKBOcKl7du+FchYZcdVQwh+6ldI3OI4mB0HpPB8j2Tcrh/CFwf90wCKYRyuvdp3BwaLbrEbEe1fNfHYGlE9YPVcyL5tM7TwXhyYpn8bbIx4wIdHMTHgOIOnsPbFkjEr1Ps9UQJRhCpsMgW/qIXIHLU6hoRQXNGepsXpiFfVcmugSZFI8tILRU+niA8oU7fj0LFM4V0JUw==; bm_sv=F05782F16144A15A477922282F0BF7B6~YAAQPfTfFzRIXf+CAQAAhYSRHBE8r3Wm8YL/q7cXLGb5cQl+EBp5uLzDRNr9cZnXiEOcw6/iK+U0jKoMBcH9KmM3Zo9ZECRcXJ0pwhsi2XSgiwXBT63j6MiOm72AWJOqgIr7WCX6suSxi+jvVC/p2dTVCUjrvUVDiDHdQkS5NZbROdnHcwP9hdWwWrW7/Xt+PkBxE3RukvTHCa6onW1fya22fxin05nuNUTI58XsdGJPfq6YIXI0eScVEpnmVSo=~1; bm_sz=0934D0CF924213D0F9694BDE6F295A74~YAAQhKg7F8IWGPSCAQAAdVETHBFPZjg723brfpFZdub2jT5CRjroKVvLg3JjQLofUFIvcMJrawsySwKu2QlFr4D4e0Ozbd3SQMduE1sPlxvsNaStkiS5QRFCvPifxYSEn0uTj2v6Ej+/87GeKHmYZuJK3dtU8+7BVEgRZ4WlVN7LJICwYj4qDCI8bbo1YJvUFw1iuYrmacXQMQgT1qlnqIswEiZ5JdssldYw+5TMQMci5tCTtSR7CyYE+2W2wnik5/uJKeSeVRh9j/NYEf27EmYTdO1bb9mffZeuGDdHAa32iQ==~3227957~3158597; fdx_cbid=10544296391657109399004850453631; level=test; siteDC=wtc'
                    ),
        ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    $Auth = json_decode($response, true);
                    $token = $Auth['access_token'];
                    return $token;

    }

    public static function FedexShippingLabel($params){

        $token = self::AuthenticateFedExUser();
        
        // dd();
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://apis-sandbox.fedex.com/ship/v1/shipments',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'
                    {
                    "labelResponseOptions": "URL_ONLY",
                    "requestedShipment": {
                        "shipper": {
                        "contact": {
                            "personName": "'.$params['shipper_name'].'",
                            "phoneNumber": '.$params['shipper_phone_no'].',
                            "companyName": "'.$params['shipper_store_name'].'"
                        },
                        "address": {
                            "streetLines": [
                            "'.$params['shipper_street_line'].'"
                            ],
                            "city": "'.$params['shipper_city'].'",
                            "stateOrProvinceCode": "'.$params['shipper_state'].'",
                            "postalCode": "'.$params['shipper_zipcode'].'",
                            "countryCode": "'.$params['shipper_country_code'].'"
                        }
                        },
                        "recipients": [
                        {
                            "contact": {
                            "personName": "'.$params['to_name'].'",
                            "phoneNumber": '.$params['to_phone_no'].',
                            "companyName": "'.$params['to_company'].'"
                            },
                            "address": {
                            "streetLines": [
                                "'.$params['to_address'].'",
                                "RECIPIENT STREET LINE 2"
                            ],
                            "city": "'.$params['to_city'].'",
                            "stateOrProvinceCode": "'.$params['to_state'].'",
                            "postalCode": "'.$params['to_zipcode'].'",
                            "countryCode": "'.$params['to_country_code'].'"
                            }
                        }
                        ],
                        "shipDatestamp": "'.$params['shipping_date'].'",
                        "serviceType": "PRIORITY_OVERNIGHT",
                        "packagingType": "FEDEX_PAK",
                        "pickupType": "USE_SCHEDULED_PICKUP",
                        "blockInsightVisibility": false,
                        "shippingChargesPayment": {
                        "paymentType": "SENDER"
                        },
                        "shipmentSpecialServices": {
                        "specialServiceTypes": [
                            "RETURN_SHIPMENT"
                        ],
                        "returnShipmentDetail": {
                            "returnType": "PRINT_RETURN_LABEL"
                        }
                        },
                        "labelSpecification": {
                        "imageType": "PDF",
                        "labelStockType": "PAPER_85X11_TOP_HALF_LABEL"
                        },
                        "requestedPackageLineItems": [
                        {
                            "weight": {
                            "value": '.$params['weight'].',
                            "units": "LB"
                            }
                        }
                        ]
                    },
                    "accountNumber": {
                        "value": "740561073"
                    }
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'x-locale: en_US',
                        'x-customer-transaction-id: 624deea6-b709-470c-8c39-4b5511281492',
                        'Authorization: Bearer '.$token,
                        'Cookie: _abck=CE1C42A2FE122BA7F0080A11B1927269~-1~YAAQhKg7F8AWGPSCAQAAdVETHAiW2yzoKMjBIFNF2wCFpaQMlXOtTl3rVtaBXjJP+ajRX9DNZ/fCHfc+8crJ5zYXwGcs46hdSxHh6JXwGJnWryFbUBb+ZMEbb0ZHnvKySC5/eNPZVoMlcM2XluOjcfi5xgenlK2hlX399La52DDHwhjmTaTc5cbIc2/tjMo6xZ8VKmDhz/Zj2QC9MNNe/6m1wRwyGQ+2Qsz2czRe1KKWBrOQQ+4gBaRUq2PqqofCzNqegVObeEOYKy8dWrW6zFEuPGJA3No0ukeC1Hf86QYfBkZqPoTfuCNVeg2yveLP2mLO+x+QvnipWeBiz/k7zWLw5BUIwmwS6PmRo5GV3GdnEzAhxjqYe8Aq0aDnN2QpzTM3zV3H~-1~-1~-1; ak_bmsc=B552D78874D1AEA9477B2EDE52F26916~000000000000000000000000000000~YAAQrPTfFyHIvv2CAQAAphR9HBG6T1nFu7BWUe8EUJ1cZ1iMuYjvleSea2xArsD2Mw5/gUPbIyaB9oynoElsSJ/lWFZ2BMjXlZQSwVFVAHEdYpKI9unPeoAuGVSR97329wC/Rz//SMKRAp1+CXXxMdwxaJY//DPk+Oqz1DDfEaDSmK7eVBKBOcKl7du+FchYZcdVQwh+6ldI3OI4mB0HpPB8j2Tcrh/CFwf90wCKYRyuvdp3BwaLbrEbEe1fNfHYGlE9YPVcyL5tM7TwXhyYpn8bbIx4wIdHMTHgOIOnsPbFkjEr1Ps9UQJRhCpsMgW/qIXIHLU6hoRQXNGepsXpiFfVcmugSZFI8tILRU+niA8oU7fj0LFM4V0JUw==; bm_sv=F05782F16144A15A477922282F0BF7B6~YAAQPfTfFzRIXf+CAQAAhYSRHBE8r3Wm8YL/q7cXLGb5cQl+EBp5uLzDRNr9cZnXiEOcw6/iK+U0jKoMBcH9KmM3Zo9ZECRcXJ0pwhsi2XSgiwXBT63j6MiOm72AWJOqgIr7WCX6suSxi+jvVC/p2dTVCUjrvUVDiDHdQkS5NZbROdnHcwP9hdWwWrW7/Xt+PkBxE3RukvTHCa6onW1fya22fxin05nuNUTI58XsdGJPfq6YIXI0eScVEpnmVSo=~1; bm_sz=0934D0CF924213D0F9694BDE6F295A74~YAAQhKg7F8IWGPSCAQAAdVETHBFPZjg723brfpFZdub2jT5CRjroKVvLg3JjQLofUFIvcMJrawsySwKu2QlFr4D4e0Ozbd3SQMduE1sPlxvsNaStkiS5QRFCvPifxYSEn0uTj2v6Ej+/87GeKHmYZuJK3dtU8+7BVEgRZ4WlVN7LJICwYj4qDCI8bbo1YJvUFw1iuYrmacXQMQgT1qlnqIswEiZ5JdssldYw+5TMQMci5tCTtSR7CyYE+2W2wnik5/uJKeSeVRh9j/NYEf27EmYTdO1bb9mffZeuGDdHAa32iQ==~3227957~3158597; fdx_cbid=10544296391657109399004850453631; level=test; siteDC=wtc'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // dd(json_decode($response, true));
                return json_decode($response, true);


    }




    public static function trackCourier($tracking_id){
        try{
         
        if($tracking_id){
       
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
                   
                    return array('status'=>true,'data'=> $av);
            }else{
                $uspsErrorData = isset($array_data['TrackInfo']['Error']) ? 
                                    $array_data['TrackInfo']['Error']['Description']:
                                    $array_data['TrackInfo']['TrackSummary'];
                                 
               return array('status'=>false,'data'=> []);
            }



        }
        return array('status'=>false,'data'=> []);
        }catch(\Exception $ex){
            return false;
        }
    }

    public static function trackFedexCourier($tracking_id='795497766120'){

        $token = self::AuthenticateFedExUser();
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://apis-sandbox.fedex.com/track/v1/trackingnumbers',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "trackingInfo": [
                        {
                        "trackingNumberInfo": {
                            "trackingNumber": "795497766120"
                        }
                        }
                    ],
                    "includeDetailedScans": true
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'x-customer-transaction-id: 624deea6-b709-470c-8c39-4b5511281492',
                        'x-locale: en_US',
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$token,
                        'Cookie: _abck=CE1C42A2FE122BA7F0080A11B1927269~-1~YAAQhKg7F8AWGPSCAQAAdVETHAiW2yzoKMjBIFNF2wCFpaQMlXOtTl3rVtaBXjJP+ajRX9DNZ/fCHfc+8crJ5zYXwGcs46hdSxHh6JXwGJnWryFbUBb+ZMEbb0ZHnvKySC5/eNPZVoMlcM2XluOjcfi5xgenlK2hlX399La52DDHwhjmTaTc5cbIc2/tjMo6xZ8VKmDhz/Zj2QC9MNNe/6m1wRwyGQ+2Qsz2czRe1KKWBrOQQ+4gBaRUq2PqqofCzNqegVObeEOYKy8dWrW6zFEuPGJA3No0ukeC1Hf86QYfBkZqPoTfuCNVeg2yveLP2mLO+x+QvnipWeBiz/k7zWLw5BUIwmwS6PmRo5GV3GdnEzAhxjqYe8Aq0aDnN2QpzTM3zV3H~-1~-1~-1; ak_bmsc=03BB9F921A9058227B0D456E44C4D135~000000000000000000000000000000~YAAQTq0cuHEwtPyCAQAAWq0nIRF+9die521FiVFBTXeExLS1ILlhSfYV6qo6x975oBpPPyxPUnmPyq/AeUXJ132VK5LdjCm/+V4KaRnvYuhMBdXyeXkhFbJAlFKhAvyvBQuqUhMT3YHxZ2iLOgYqwEbz1/mH4tMmFJdvl/geuGAEFCpWX+Dbv1fpG1khyvjQbbHZ2JMgq7xyiFcOEG/Xuumxxnbuae77pLrnDZZICtQu0x7bgcHhZvI2Q8B1DX8kN9lRL2FgVdegzZUOYLluHXt/ItyQ9rmbJ/+48Bk50QoUYS7+cVT8HQXUo02i7F/flwNmYpCBvGma1AsyNSeDPVaUmkfd3MAvnMr0ISM6ettmIYJAwei8toRiSHI=; fdx_cbid=10544296391657109399004850453631; siteDC=wtc'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    return json_decode($response, true);


    }

    public static function getShippingPrice($product){
        try{

                // dd($product->toArray());
                $demensions  = json_decode($product->dimensions, true);
                //dd($demensions);
                $length = $demensions["Length"];
                $breadth = $demensions['Breadth'];
                $height = $demensions['Height'];
                $input_xml = <<<EOXML
                    <RateV4Request USERID="641IHERB6005">
                    <Revision>2</Revision>
                    <Package ID="1">
                    <Service>PRIORITY</Service>
                    <ZipOrigination>20770</ZipOrigination>
                    <ZipDestination>22201</ZipDestination>
                    <Pounds>50</Pounds>
                    <Ounces>05</Ounces>
                    <Container></Container>
                    <Width>$length</Width>
                    <Length>$breadth</Length>
                    <Height>$height</Height>
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

          
            $error = json_decode(json_encode(simplexml_load_string($data)), true);
            if(isset($error['Package']['Error'])){
           
                return $error['Package']['Error']['Description'];
            }
                $data = json_decode(json_encode(simplexml_load_string($data)), true);
                return  $data['Package']['Postage']['Rate'];
         
                    
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
            
            $url = 'https://secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
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




    public static function SchedulePickup($store_id, $weight, $no_of_product,$package_location_desc=''){
        try{
            $store = Store::FindOrfail($store_id);
           // dd($store->toArray());
            $fname = Auth::user()->fname;
            $lname = Auth::user()->lname;
            $phone = Auth::user()->mobile_no;
            $input_xml = <<<EOXML
                            <CarrierPickupScheduleRequest USERID="641IHERB6005">
                            <FirstName>$fname</FirstName>
                            <LastName>$lname</LastName>
                            <FirmName>$store->name.</FirmName>
                            <SuiteOrApt>$store->location</SuiteOrApt>
                            <Address2>$store->address</Address2>
                            <Urbanization></Urbanization>
                            <City>$store->city</City>
                            <State>$store->state</State>
                            <ZIP5>$store->zipcode</ZIP5>
                            <ZIP4></ZIP4>
                            <Phone>$phone</Phone>
                            <Extension>201</Extension>
                            <Package>
                            <ServiceType>PriorityMailExpress</ServiceType>
                            <Count>$no_of_product</Count>
                            </Package>
                            <Package>
                            <ServiceType>PriorityMail</ServiceType>
                            <Count>$no_of_product</Count>
                            </Package>
                            <EstimatedWeight>$weight</EstimatedWeight>
                            <PackageLocation>Front Door</PackageLocation>
                            <SpecialInstructions>$package_location_desc</SpecialInstructions>
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
                    // dd(json_decode(json_encode(simplexml_load_string($data)), true));
                    $data = json_decode(json_encode(simplexml_load_string($data)), true);
                    if(isset($data['Description'])){
                        return array('status' => false, 'message'=> $data['Description'], 'data' =>[]);
                    }
                    return array('status' => true, 'message'=> "Schedule pcikup successfully!", 'data' => $data);
                            
                }catch(\Exception $ex){
                    return parent::error($ex->getMessage());
                }
    }


    public static function eVS(){
        try{

            $input_xml = <<<EOXML
                            <eVSRequest USERID= "641IHERB6005">
                            <Option/>
                            <Revision/>
                            <ImageParameters>
                            <LabelSequence>
                            <PackageNumber>1</PackageNumber>
                            <TotalPackages>1</TotalPackages>
                            </LabelSequence>
                            </ImageParameters>
                            <FromName>Lina Smith</FromName>
                            <FromFirm>Horizon</FromFirm>
                            <FromAddress1>Apt 303</FromAddress1>
                            <FromAddress2>1309 S Agnew Avenue</FromAddress2>
                            <FromCity>Oklahoma City</FromCity>
                            <FromState>OK</FromState>
                            <FromZip5>73108</FromZip5>
                            <FromZip4>2427</FromZip4>
                            <FromPhone>1234567890</FromPhone>
                            <POZipCode/>
                            <AllowNonCleansedOriginAddr>false</AllowNonCleansedOriginAddr>
                            <ToName>Tall Tom</ToName>
                            <ToFirm>ABC Corp.</ToFirm>
                            <ToAddress1/>
                            <ToAddress2>1098 N Fraser Street</ToAddress2>
                            <ToCity>Georgetown</ToCity>
                            <ToState>SC</ToState>
                            <ToZip5>29440</ToZip5>
                            <ToZip4>2849</ToZip4>
                            <ToPhone>8005554526</ToPhone>
                            <POBox/>
                            <ToContactPreference>email</ToContactPreference>
                            <ToContactMessaging/>
                            <ToContactEMail>talltom@aol.com</ToContactEMail>
                            <AllowNonCleansedDestAddr>false</AllowNonCleansedDestAddr>
                            <WeightInOunces>32</WeightInOunces>
                            <ServiceType>PRIORITY</ServiceType>
                            <Container>VARIABLE</Container>
                            <Width>5.5</Width>
                            <Length>11</Length>
                            <Height>11</Height>
                            <Machinable>TRUE</Machinable>
                            <ProcessingCategory/>
                            <PriceOptions/>
                            <InsuredAmount>100.00</InsuredAmount>
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
                            <CRID>4569873</CRID>
                            <MID>456789354</MID>
                            <VendorCode>1234</VendorCode>
                            <VendorProductVersionNumber>5.02.1B</VendorProductVersionNumber>
                            <SenderName>Adam Johnson</SenderName>
                            <SenderEMail>Adam1234d@aol.com</SenderEMail>
                            <RecipientName>Robert Jones</RecipientName>
                            <RecipientEMail>bobjones@aol.com</RecipientEMail>
                            <ReceiptOption>SAME PAGE</ReceiptOption>
                            <ImageType>PDF</ImageType>
                            <HoldForManifest>N</HoldForManifest>
                            <NineDigitRoutingZip>false</NineDigitRoutingZip>
                            <ShipInfo>True</ShipInfo>
                            <CarrierRelease>False</CarrierRelease>
                            <DropOffTime/>
                            <ReturnCommitments>True</ReturnCommitments>
                            <PrintCustomerRefNo>False</PrintCustomerRefNo>
                            <PrintCustomerRefNo2>True</PrintCustomerRefNo2>
                            <Content>
                            <ContentType>Perishable</ContentType>
                            <ContentDescription>Other</ContentDescription>
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
                   
                    $data = json_decode(json_encode(simplexml_load_string($data)), true);
                    dd($data);
                    // $pdf_decoded = base64_decode ($data['LabelImage']);

                    // $pdf = fopen ('shipping_label/'.time().rand(1111,9999).'label.pdf','w');
                    // fwrite ($pdf,$pdf_decoded);
                    // dd('done');
                            
                }catch(\Exception $ex){
                    return parent::error($ex->getMessage());
                }
    }






    public static function SendVarificationEmail($email, $name, $message, $header="Consign-it-away"){

        $sendGridMail = new \SendGrid\Mail\Mail();
        $sendGridMail->setFrom(getenv('MAIL_ADDRESS'), "ConsignItAway");
        $sendGridMail->setSubject("OTP Verification Mail");
        $sendGridMail->addTo($email, $name);
        $sendGridMail->addContent("text/plain", $header);
        $sendGridMail->addContent("text/html",$message);
        
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $response = $sendgrid->send($sendGridMail);
        return true;
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
        // exit;
    }


    public static function VerifyAddressBeforeAdd($input){
      
        try{
            $address = $input['address'];
            $city = $input['city'];
            $state = $input['state'];
            $zipcode = $input['zipcode'];
                $input_xml = <<<EOXML
                        <AddressValidateRequest USERID="641IHERB6005">
                            <Address ID="1">
                                <Address1></Address1>
                                <Address2>$address</Address2>
                                <City>$city</City>
                                <State>$state</State>
                                <Zip5>$zipcode</Zip5>
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
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
        //  dd($array_data);
          
                    if(array_key_exists('Error', $array_data['Address'])):
                            return array('status'=> false, 'message' => $array_data['Address']['Error']['Description']);
                        else:
                            return array('status'=> true, 'message' => $array_data['Address']);
                    endif;     
      
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }

public static function BarcodeLookup($params){

            $barcode = $params['barcode'];
            $key = $params['key'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.barcodelookup.com/v3/products?barcode=$barcode&key=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cf_bm=F3hAbNXtmodclJMEp_uzQO1djJeZqeur_vFT5pM1s9g-1662353038-0-AVgMHo82oah8NKuZQrpxe/YjwxWrnsetJZ2RVKZ+X1vtFMjBy0HdFNof4vHVLbbIxLQWFZ9ia+iIlIfLALMxPiq9KJhSGiT5+pafAwigyuao; bl_csrf=27a7972e50c9eaa4a922f54c214a4007; bl_session=oumjrkbvp0ag930q5s404n79bi1k77da; __cflb=0H28uyvJ4CKpQyt4K4sAVoNGmQD7bdrd7NJRPcFyAyT'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response, true);


}


public static function FedExSchedulePickup($params)
{
    try{
            // dd($params);
            $token = self::AuthenticateFedExUser();
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://apis-sandbox.fedex.com/pickup/v1/pickups',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "associatedAccountNumber": {
                    "value": "740561073"
                },
                "originDetail": {
                    "pickupLocation": {
                    "contact": {
                        "personName": "'.$params['sender_name'].'",
                        "phoneNumber": "'.$params['sender_phone_no'].'"
                    },
                    "address": {
                        "streetLines": [
                        "'.$params['sender_address'].'"
                        ],
                        "city": "'.$params['sender_city'].'",
                        "stateOrProvinceCode": "'.$params['sender_state'].'",
                        "postalCode": "'.$params['sender_zipcode'].'",
                        "countryCode": "'.$params['sender_country'].'"
                    }
                    },
                    "packageLocation": "'.$params['package_location'].'",
                    "readyDateTimestamp": "'.$params['pickup_date'].'",
                    "customerCloseTime": "'.$params['sender_closing_time'].'"
                },
                "carrierCode": "FDXG"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'x-locale: en_US',
                    'x-customer-transaction-id: 6ff590ee-4db0-4642-8c04-c4085000aae3',
                    'Authorization: Bearer '.$token,
                    'Cookie: _abck=CE1C42A2FE122BA7F0080A11B1927269~-1~YAAQhKg7F8AWGPSCAQAAdVETHAiW2yzoKMjBIFNF2wCFpaQMlXOtTl3rVtaBXjJP+ajRX9DNZ/fCHfc+8crJ5zYXwGcs46hdSxHh6JXwGJnWryFbUBb+ZMEbb0ZHnvKySC5/eNPZVoMlcM2XluOjcfi5xgenlK2hlX399La52DDHwhjmTaTc5cbIc2/tjMo6xZ8VKmDhz/Zj2QC9MNNe/6m1wRwyGQ+2Qsz2czRe1KKWBrOQQ+4gBaRUq2PqqofCzNqegVObeEOYKy8dWrW6zFEuPGJA3No0ukeC1Hf86QYfBkZqPoTfuCNVeg2yveLP2mLO+x+QvnipWeBiz/k7zWLw5BUIwmwS6PmRo5GV3GdnEzAhxjqYe8Aq0aDnN2QpzTM3zV3H~-1~-1~-1; ak_bmsc=5F581410F472B5D17A72239202488A4C~000000000000000000000000000000~YAAQPfTfF53BKzWDAQAAdkKwNhFPeOAMts1wl7Sf6ifZfyYv7SIYrb5JsJJbM78JHqFe0Baats6d/8vRWq7aZTdoJ0ebvCp5D+kHYlMdVgr8/8KMV+xAUpLiNuerLwoTXs+3Ih4v4wl29HiEsEy8rjNiDT6NUEWY5siQE3hqn9aufE2P8TwaH3ZuXzk/ufp3O5sl7JfUOi6ACdVAfIR+87Uw1nR6EzBEsamWNMx4tluflHu2p8dkUhfJSJaUMi0vMuWTjr0aFjKUpF6FJyxdIDXRJzSDjRMIl9T2qcJ4YzseZi7eD+T3uFJfsiiXKLYeR5HPoNZWv0HwsRfCNBtGTjhOFWRpCBurAgVNcJ7j8jgW421Bm6HI0xXgMQ==; bm_sv=EF2FA6099E8575B778BCE08B6E4EF507~YAAQrPTfFzY3Jf6CAQAA3qmxNhGVj9XtNnqUC+CbPNuxVAYADmmcfubZZ17P3R8yPcUv/wY0cqHWfvOVjy7ID/DUpV+P6b2NRKftRJvlOAJYlnrEuPvTbnjnqzQ5x7g+b/77pn8E9Lvc3MLS8EAmyb3wArnnlBzbBOFTp4ldL3+afk0kr+ZxR/uh4mc0D8YpecIUCwzvP0kz89lg/Rkwp51AP54/OvagHGuno6vJtgUOLhR2P8d5MQSWBY8eVFs=~1; fdx_cbid=10544296391657109399004850453631'
                ),
        ));

                $response = curl_exec($curl);
                curl_close($curl);
                return json_decode($response, true); 


    }catch(\exception $ex){
        return parent::error($ex->getMessage());
    }
}









    
}

