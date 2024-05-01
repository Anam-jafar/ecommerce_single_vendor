@extends('users_end.layouts.template')

@section('title')
Customer Service
@endsection

@section('content')
<section class="customer_service_section">
    <div class="container">
        <div class="row p-5 mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="section-title">Customer Service</h2>
                        <p class="section-description">Welcome to our customer service page. We're here to assist you with any questions or concerns you may have.</p>
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <h3>Contact Information</h3>
                                <ul>
                                    <li><i class="fa fa-phone"></i> Phone: 1-800-123-4567</li>
                                    <li><i class="fa fa-envelope"></i> Email: support@example.com</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3>Frequently Asked Questions</h3>
                                <ul>
                                    <li><a href="#">Shipping & Delivery</a></li>
                                    <li><a href="#">Returns & Exchanges</a></li>
                                    <li><a href="#">Product Information</a></li>
                                    <li><a href="#">Payment & Billing</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Support Center</h3>
                        <p>If you couldn't find the answer to your question in our FAQs, please submit a support ticket:</p>
                        <a href="#" class="btn btn-warning btn-block">Submit Ticket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
