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
                   
                    return array('status'=>true,'data'=> $av);
            }else{
                $uspsErrorData = isset($array_data['TrackInfo']['Error']) ? 
                                    $array_data['TrackInfo']['Error']['Description']:
                                    $array_data['TrackInfo']['TrackSummary'];
                                 
               return array('status'=>false,'data'=> []);
            }



        }

        }catch(\Exception $ex){
            return false;
        }
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
                    $pdf_decoded = base64_decode ($data['LabelImage']);

                    $pdf = fopen ('shipping_label/'.time().rand(1111,9999).'label.pdf','w');
                    fwrite ($pdf,$pdf_decoded);
                    dd('done');
                            
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
        //   dd($array_data);
          
                    if(array_key_exists('Error', $array_data['Address'])):
                            return array('status'=> false, 'message' => $array_data['Address']['Error']['Description']);
                        else:
                            return array('status'=> true, 'message' => $array_data['Address']['ReturnText']);
                    endif;     
      
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }














    
}

