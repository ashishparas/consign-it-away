@extends('layouts.app')


@section('content')


<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/diamond.svg')}}"> Subscription Management</li>
          </ol>
        </nav>
      </div>
    </div> 
    <!--breadcrumbs-->
    <!--shipping-orders-->
    <div class="row align-items-start">
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header border-0 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Subscription Management</h3>
                    <span>
                        <a href="javascript:void()" class="btn green_btn">+ Add More Plan</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-12 mt-4">
            <div class="ms-panel ms-panel-fh">
                <div class="ms-panel-body">
                    <ul class="nav nav-tabs d-flex nav-justified mb-4 w-50 w-m-100 m-auto subscription_menu" role="tablist">
                        <li role="presentation"><a href="#tab13" aria-controls="tab13" class="active" role="tab" data-toggle="tab">Monthly</a></li>
                        <li role="presentation"><a href="#tab14" aria-controls="tab14" role="tab" data-toggle="tab">Annually </a></li>
                      </ul>
        
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active show fade in" id="tab13">
                <div class="accordion mt-4" id="accordionExample3">
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Bronze</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                               <a href="#" class="badge badge-dark p-2"><strong>$ 0.00</strong> Only</a>
                            </span>
                        </div>
                      </div>
      
                      <div id="collapseSeven" class="collapse show" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Sliver</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                                <a href="#" class="badge badge-dark p-2"><strong>$ 9.99</strong> Only</a>
                             </span>
                        </div>
                      </div>
      
                      <div id="collapseEight" class="collapse" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Gold</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                                <a href="#" class="badge badge-dark p-2"><strong>$ 39.99</strong> Only</a>
                             </span>
                        </div>
                      </div>
      
                      <div id="collapseNine" class="collapse" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>
             
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab14">
                <div class="accordion mt-4" id="accordionExample3">
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Free Plan</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                               <a href="#" class="badge badge-dark p-2"><strong>$ 0.00</strong> Only</a>
                            </span>
                        </div>
                      </div>
      
                      <div id="collapseSeven" class="collapse show" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Monthly Plan</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                                <a href="#" class="badge badge-dark p-2"><strong>$ 9.99</strong> Only</a>
                             </span>
                        </div>
                      </div>
      
                      <div id="collapseEight" class="collapse" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Yearly Plan</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                                <a href="#" class="badge badge-dark p-2"><strong>$ 39.99</strong> Only</a>
                             </span>
                        </div>
                      </div>
      
                      <div id="collapseNine" class="collapse" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab15">
                <div class="accordion mt-4" id="accordionExample3">
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Free Plan</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                               <a href="#" class="badge badge-dark p-2"><strong>$ 0.00</strong> Only</a>
                            </span>
                        </div>
                      </div>
      
                      <div id="collapseSeven" class="collapse show" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Monthly Plan</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                                <a href="#" class="badge badge-dark p-2"><strong>$ 9.99</strong> Only</a>
                             </span>
                        </div>
                      </div>
      
                      <div id="collapseEight" class="collapse" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header header_bg" data-toggle="collapse" role="button" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="mb-1">Yearly Plan</h5>
                                <p class="pb-0 mb-0">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                            </div>
                            <span>
                                <a href="#" class="badge badge-dark p-2"><strong>$ 39.99</strong> Only</a>
                             </span>
                        </div>
                      </div>
      
                      <div id="collapseNine" class="collapse" data-parent="#accordionExample3">
                        <div class="card-body">
                            <ul class="free_lisitng subscription_listing">
                                <li>
                                  <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus non volutpat. </li>
                                <li> <span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est.</li>
                                <li><span><svg xmlns="http://www.w3.org/2000/svg" width="13.709" height="10.967" viewBox="0 0 13.709 10.967">
                                  <path id="Icon_metro-spell-check" data-name="Icon metro-spell-check" d="M22.064,18.723l-8.911,9.6-4.8-6.169,1.756-1.5,3.042,3.17,7.54-6.469Z" transform="translate(-8.355 -17.352)" fill="#858585"></path>
                                </svg></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et pretium nunc. Proin nec rhoncus purus. Curabitur vel eleifend est. Nunc aliquet sed lectus.</li>
                              </ul>
                              <div class="col-md-12 text-center pb-3">
                                <button type="button" class="btn green_btn_light p-2">Edit</button>
                                <button type="button" class="btn orange_btn_light p-2">Delete</button>
        
                              </div>
                        </div>
                      </div>
                    </div>
                  </div>
          </div>
                </div>
            
            </div>
        </div>
        
    </div>
    <!--shipping-orders-->
</div>




@endsection