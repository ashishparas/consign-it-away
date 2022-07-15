<?php // Code within app\Helpers\Helper.php

namespace App\Helper;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\API\ApiController;
use App\Models\Address;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

    // userId: 778CONSI5321
class Helper extends ApiController
{
    
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



    public static function VerifyAddress(int $id=null){
        try{

        $address = Address::FindOrfail($id);
   
        if($address):

    $input_xml = <<<EOXML
                        <AddressValidateRequest USERID="778CONSI5321">
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
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
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

                        <eVSRequest USERID= "778CONSI5321">
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
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
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
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            
            // Convert the XML result into array
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
            if(array_key_exists('Error', $array_data['TrackInfo'])):
                return false;
            else:
                return $array_data['TrackInfo'];
            endif;
            
            }else{
                return false;
            }

        }catch(\Exception $ex){
            return false;
        }
    }


    public static function getShippingPrice(){
        try{

    $input_xml = <<<EOXML
                    <RateV4Request USERID="778CONSI5321">
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
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
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
                            <USPSReturnsLabelRequest USERID="778CONSI5321">
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
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
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

