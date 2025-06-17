<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        h2 {
            color: #3498db;
            margin-top: 30px;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin: 20px 0 30px;
            font-weight: bold;
        }
        
        .progress-steps span {
            color: #7f8c8d;
        }
        
        .progress-steps span.active {
            color: #3498db;
        }
        
        .form-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .form-section.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .radio-group {
            margin: 10px 0;
        }
        
        .radio-group label {
            display: inline-block;
            margin-right: 15px;
            font-weight: normal;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .button-group {
            margin-top: 20px;
            text-align: right;
        }
        
        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        button.secondary {
            background-color: #95a5a6;
        }
        
        hr {
            border: 0;
            height: 1px;
            background-color: #eee;
            margin: 30px 0;
        }
        
        /* GSTIN specific styles */
        .gstin-fields {
            display: none;
            margin-top: 15px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .gstin-container {
            margin-bottom: 15px;
        }
        
        .gstin-row {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .gstin-row > div {
            flex: 1;
        }
        
        .add-another {
            color: #3498db;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }
        
        .note {
            font-size: 0.9em;
            color: #666;
            margin-top: 15px;
            font-style: italic;
        }
        
        .remove-gstin {
            color: #e74c3c;
            text-decoration: none;
            font-size: 0.8em;
            margin-left: 10px;
            cursor: pointer;
        }
        
        .upload-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px dashed #ccc;
            border-radius: 5px;
        }
        
        .upload-section h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .upload-instructions {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }
        
        .download-agreement {
            display: inline-block;
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .gstin-display {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Account Setup</h1>
    
    <p>Please fill in the below details so that we can setup an account for your organisation in our system and give you access to the Do-It-Yourself portal for listing your event.</p>
    
    <div class="progress-steps">
        <span id="step1" class="active">1. General Information</span>
        <span id="step2">2. Upload documents</span>
        <span id="step3">3. Sign agreement</span>
    </div>
    
    <hr>
    
    <!-- General Information Section -->
    <div id="general-info" class="form-section active">
        <h2>Organisation Details</h2>
        
        <div class="form-group">
            <label>Organisation/Individual Name <span>( )</span></label>
            <input type="text" placeholder="Enter your organisation name">
        </div>
        
        <div class="form-group">
            <label>Organisation/Individual PAN card number</label>
            <input type="text" placeholder="Enter PAN card number">
        </div>
        
        <div class="form-group">
            <label>Organisation/Individual Address <span>( )</span></label>
            <input type="text" placeholder="Enter your organisation address">
        </div>
        
        <div class="form-group">
            <label>Do you have a GSTIN number?</label>
            <div class="radio-group">
                <label><input type="radio" name="gstin" value="yes" id="gstin_yes"> Yes</label>
                <label><input type="radio" name="gstin" value="no" id="gstin_no" checked> No</label>
            </div>
            
            <div class="gstin-fields" id="gstin_fields">
                <div class="gstin-container" id="gstin_template">
                    <div class="gstin-row">
                        <div>
                            <label>GSTIN Number</label>
                            <input type="text" placeholder="Enter your GSTIN Number">
                        </div>
                        <div>
                            <label>State</label>
                            <select>
                                <option value="">Select State</option>
                                <option value="AN">Andaman and Nicobar Islands</option>
                                <option value="AP">Andhra Pradesh</option>
                                <!-- Add all other states -->
                                <option value="WB">West Bengal</option>
                            </select>
                        </div>
                    </div>
                    <a href="#" class="remove-gstin">Remove</a>
                </div>
                
                <div id="gstin_fields_container"></div>
                
                <a href="#" class="add-another" id="add_gstin">+ Add another GSTIN number</a>
                
                <p class="note">Note: You can add multiple GSTIN numbers and certificates for different states later through profile section of DIY.</p>
            </div>
        </div>
        
        <div class="form-group">
            <label>Have you filled last 2 years ITR return?</label>
            <div class="radio-group">
                <label><input type="radio" name="itr" value="yes"> Yes</label>
                <label><input type="radio" name="itr" value="no"> No</label>
            </div>
        </div>
        
        <h2>Contact Person Details</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email address</th>
                    <th>Mobile Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" placeholder="Enter your full name"></td>
                    <td><input type="email" placeholder="Enter your email address"></td>
                    <td><input type="tel" placeholder="Enter your mobile number"></td>
                </tr>
            </tbody>
        </table>
        
        <h2>Bank details</h2>
        
        <table>
            <tbody>
                <tr>
                    <td><input type="text" placeholder="Enter Beneficiary Name"></td>
                    <td>
                        <select>
                            <option value="">Select an account type</option>
                            <option value="savings">Savings</option>
                            <option value="current">Current</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="text" placeholder="Bank Name"></td>
                    <td><input type="text" placeholder="Account Number"></td>
                    <td><input type="text" placeholder="Bank IFSC"></td>
                </tr>
            </tbody>
        </table>
        
        <div class="button-group">
            <button id="next-to-upload">Proceed to Upload Documents</button>
        </div>
    </div>
    
    <!-- Upload Documents Section -->
    <div id="upload-docs" class="form-section">
        <h2>Upload Documents</h2>
        
        <div class="upload-section">
            <h3>Upload PAN card</h3>
            <div class="upload-instructions">
                Please make sure that:
                <ul>
                    <li>Upload a clear image in .jpg or .pdf format only.</li>
                    <li>File size should not be greater than 2mb.</li>
                </ul>
            </div>
            
            <input type="file" accept=".jpg,.pdf">
        </div>
        
        <div class="upload-section">
            <h3>Upload Cancelled Cheque</h3>
            <div class="upload-instructions">
                Please make sure that:
                <ul>
                    <li>Upload a clear image in .jpg or .pdf format only.</li>
                    <li>File size should not be greater than 2mb.</li>
                </ul>
            </div>
            <input type="file" accept=".jpg,.pdf">
        </div>
        
        <div class="upload-section">
            <h3>Upload GST Certificate</h3>
            <div class="upload-instructions">
                Please make sure that:
                <ul>
                    <li>Upload a clear image in .jpg or .pdf format only.</li>
                    <li>File size should not be greater than 2mb.</li>
                </ul>
            </div>
            
            <div class="gstin-display">
                GSTIN: 09EEEEE7890E529<br>
                State: Uttar Pradesh
            </div>
            <input type="file" accept=".jpg,.pdf">
        </div>
        
        <div class="button-group">
            <button class="secondary" id="back-to-general">Back</button>
            <button id="next-to-agreement">Proceed to Agreement</button>
        </div>
    </div>
    
    <!-- Sign Agreement Section -->
    <div id="sign-agreement" class="form-section">
        <h2>Sign Agreement</h2>
        
        <div class="upload-section">
            <h3>Upload signed agreement</h3>
            <div class="upload-instructions">
                <p>Click on 'Download agreement' to download the agreement.</p>
                <p>Upload a .pdf format only. File size should not be greater than 2mb.</p>
            </div>
            <a href="#" class="download-agreement">Download agreement</a>
            <input type="file" accept=".pdf">
        </div>
        
        <div class="button-group">
            <button class="secondary" id="back-to-upload">Back</button>
            <button id="submit-all">Submit</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // GSTIN show/hide functionality
            const gstinYes = document.getElementById('gstin_yes');
            const gstinNo = document.getElementById('gstin_no');
            const gstinFields = document.getElementById('gstin_fields');
            
            gstinYes.addEventListener('change', function() {
                if(this.checked) {
                    gstinFields.style.display = 'block';
                    // Add first GSTIN field when showing
                    if(document.querySelectorAll('.gstin-container').length === 1) {
                        addGstinField();
                    }
                }
            });
            
            gstinNo.addEventListener('change', function() {
                if(this.checked) {
                    gstinFields.style.display = 'none';
                }
            });
            
            // Add GSTIN field functionality
            const addGstinBtn = document.getElementById('add_gstin');
            const gstinContainer = document.getElementById('gstin_fields_container');
            const gstinTemplate = document.getElementById('gstin_template');
            
            addGstinBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addGstinField();
            });
            
            function addGstinField() {
                const newGstin = gstinTemplate.cloneNode(true);
                newGstin.id = '';
                newGstin.style.display = 'block';
                
                // Add remove functionality
                const removeBtn = newGstin.querySelector('.remove-gstin');
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    newGstin.remove();
                });
                
                gstinContainer.appendChild(newGstin);
            }
            
            // Remove template from DOM
            gstinTemplate.style.display = 'none';
            
            // Navigation between sections
            const sections = {
                general: document.getElementById('general-info'),
                upload: document.getElementById('upload-docs'),
                agreement: document.getElementById('sign-agreement')
            };
            
            const steps = {
                step1: document.getElementById('step1'),
                step2: document.getElementById('step2'),
                step3: document.getElementById('step3')
            };
            
            // Next to Upload Documents
            document.getElementById('next-to-upload').addEventListener('click', function() {
                sections.general.classList.remove('active');
                sections.upload.classList.add('active');
                steps.step1.classList.remove('active');
                steps.step2.classList.add('active');
            });
            
            // Back to General Information
            document.getElementById('back-to-general').addEventListener('click', function() {
                sections.upload.classList.remove('active');
                sections.general.classList.add('active');
                steps.step2.classList.remove('active');
                steps.step1.classList.add('active');
            });
            
            // Next to Agreement
            document.getElementById('next-to-agreement').addEventListener('click', function() {
                sections.upload.classList.remove('active');
                sections.agreement.classList.add('active');
                steps.step2.classList.remove('active');
                steps.step3.classList.add('active');
            });
            
            // Back to Upload Documents
            document.getElementById('back-to-upload').addEventListener('click', function() {
                sections.agreement.classList.remove('active');
                sections.upload.classList.add('active');
                steps.step3.classList.remove('active');
                steps.step2.classList.add('active');
            });
            
            // Submit All
            document.getElementById('submit-all').addEventListener('click', function() {
                alert('Form submitted successfully!');
                // Here you would typically submit the form data to the server
            });
        });
    </script>
</body>
</html>