<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InsuranceNeeds;
use App\Models\Trades;
use Illuminate\Support\Facades\Log;
use PDF;
use File;

class InsuranceNeedsController extends Controller
{
    public function index() {
        $insuranceNeedsModel = new InsuranceNeeds();
        $states = $insuranceNeedsModel->getAllStates();
        $professions = $insuranceNeedsModel->getAllProfessions();
        return view('insurance-survey.index', compact('states', 'professions'));
    }

    public function thankYouPage() {
        if (!session()->has('form_submitted')) {
            return redirect('/'); // Redirect them back to form page
        }
        session()->forget('form_submitted'); // Remove the session variable
        return view('insurance-survey.thankyou');
    }

    public function emailTemplate() {
        return view('insurance-survey.email-template');
    }

    public function submitForm(Request $request) {

        Log::info('Data', $request->all());

        if ($request->isMethod('post')) {
            $tradesPerformed = $request->input('trades_performed');

            $question1Data = json_decode($request->input('question_1'), true);
            $question2Data = json_decode($request->input('question_2'), true);

            $insuranceNeeds = new InsuranceNeeds();
            $insuranceNeeds->state_id = $request->input('business_location');
            $insuranceNeeds->trades_id = json_encode($tradesPerformed); // Adjust as needed
            $insuranceNeeds->company_name = $request->input('company_name');
            $insuranceNeeds->firstname = $request->input('first_name');
            $insuranceNeeds->lastname = $request->input('last_name');
            $insuranceNeeds->address = $request->input('address');
            $insuranceNeeds->city = $request->input('city');
            $insuranceNeeds->zipcode = $request->input('zipcode');
            $insuranceNeeds->email = $request->input('email');
            $insuranceNeeds->phone_no = $request->input('phone_no');

            $insuranceNeeds->does_perform_residential_work = $question1Data['q1'];
            $insuranceNeeds->does_perform_commercial_work = $question1Data['q2'];
            $insuranceNeeds->does_have_employee = $question1Data['q3'];
            $insuranceNeeds->does_use_vehicle_in_work = $question1Data['q4'];
            $insuranceNeeds->does_work_property_above_1m = $question1Data['q5'];
            $insuranceNeeds->does_rent_equipment_or_add_up_10k = $question1Data['q6'];
            $insuranceNeeds->does_rent_office_other_than_home = $question1Data['q7'];

            $insuranceNeeds->are_you_gc_performs_remodeling = $question2Data['q1'];
            $insuranceNeeds->does_transport_materials_above_10k = $question2Data['q2'];
            $insuranceNeeds->does_perform_design_bldg_for_fee = $question2Data['q3'];
            $insuranceNeeds->does_your_website_collect_personal_info = $question2Data['q4'];
            $insuranceNeeds->does_store_transport_pollutants = $question2Data['q5'];
            $insuranceNeeds->does_use_subcontractors = $question2Data['q6'];

            $insuranceNeeds->save();

            $this->generatePdfReport($insuranceNeeds->id);

            $templateData['firstname'] = $insuranceNeeds->firstname;
            $date_created = Carbon::now();
            $formattedDateCreated = $date_created->format("F j, Y g:ia");
            $this->sendInsuranceNeedsEmail($insuranceNeeds->id, $insuranceNeeds->company_name, $templateData, $formattedDateCreated);

            session(['form_submitted' => true]);

        }
        return response()->json(['status' => 'success', 'message' => 'Data has been saved successfully.']);
    }

    function calculateQuestionsSection($pdf, $l=12, $title, $contents) {

        $currentY = $pdf->GetY();
        $topMargin = $pdf->getMargins()['top'];
        $contentHeight = $currentY - $topMargin;

        if ($contentHeight > 210) {
            $pdf->addPage();
            $pdf->SetY(25);
        }

        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->setXY($l + 5, $pdf->GetY() + 5);

        if (strlen($title) > 100) {
            $pdf->MultiCell(0, 0, $title, 0, 'L', 0, 1, $l + 5, $pdf->GetY(), true, 0, false, true, 0);
        } else {
            $pdf->Cell(0, 0, $title, 0, 0, 'L', 0, 0, 0, false, '', '');
        }

        if ($title === '10. Are you a General Contractor that performs remodel, additions, or new ground up construction for residential or commercial building?') {

            $currentY = $pdf->GetY();
            $topMargin = $pdf->getMargins()['top'];
            $contentHeight = $currentY - $topMargin;

            if ($contentHeight > 210) {
                $pdf->addPage();
                $pdf->SetY(25);
            }

            foreach ($contents as $content) {

                $pdf->SetFont('helvetica', '', 11);
                $pdf->setXY($l + 18, $pdf->GetY());
                $pdf->MultiCell(0, 0, Chr(97) . '.) ' . $content[0], 0, 'L', 0, 1, 30, $pdf->GetY(), true, 0, false, true, 0);

                if ($content[1] && $content[2]) {

                    $pdf->MultiCell(0, 0, Chr(98) . '.) ' . $content[1], 0, 'L', 0, 1, 30, $pdf->GetY(), true, 0, false, true, 0);
                    $pdf->MultiCell(0, 0, Chr(99) . '.) ' . $content[2], 0, 'L', 0, 1, 30, $pdf->GetY(), true, 0, false, true, 0);

                    $html = "<ol style='list-style-type: upper-roman;'>
                            <li><u>New Ground Up Construction Projects</u>: We recommend a Builders Risk Policy with a value
                            equal to the cost of construction. The Homeowner’s Policy or Business Property Policy will not
                            cover loss due to fire or other covered losses until the project is complete, and a certificate of
                            occupancy has been issued and the structure is put to its intended use.</li>
                            <br>
                            <li><u>Remodeling or Addition to Existing Structures</u>: We recommend a Builders Risk Policy with a value equal to the cost of construction of your remodel and or addition. The Homeowner’s Policy or Business Property Policy will not cover any loss due to fire or other covered losses until the project is complete and a certificate of occupancy has been issued and the structure is put to its intended use.</li>
                    </ol>";



                    $pdf->MultiCell(0, 0, $html, 0, 'L', 0, 1, 30, $pdf->GetY() + 5, true, 0, true, true, 0);
                }
            }
        } else {
            $pdf->SetFont('helvetica', '', 11);
            $pdf->setXY($l + 18, $pdf->GetY() + 5);

            foreach ($contents as $content) {
                if (strlen($title) < 100 ? $pdf->MultiCell(0, 0, Chr(97) . '.) ' . $content[0], 0, 'L', 0, 1, $pdf->GetX(), $pdf->GetY(), true, 0, false, true, 0) : $pdf->MultiCell(0, 0, Chr(97) . '.) ' . $content[0], 0, 'L', 0, 1, $pdf->GetX(), $pdf->GetY() - 5, true, 0, false, true, 0));
                if ($content[1]) {
                    $pdf->MultiCell(0, 0, Chr(98) . '.) ' . $content[1], 0, 'L', 0, 1, $pdf->GetX() + 20, $pdf->GetY(), true, 0, false, true, 0);
                }
                if ($content[2]) {
                    $pdf->MultiCell(0, 0, Chr(99) . '.) ' . $content[2], 0, 'L', 0, 1, $pdf->GetX() + 20, $pdf->GetY(), true, 0, false, true, 0);
                }
            }
        }
    }

    function calculateElSubconAgreement($pdf, $pageNo, $l=12, $title, $contents) {
        $currentY = $pdf->GetY();
        $topMargin = $pdf->getMargins()['top'];
        $contentHeight = $currentY - $topMargin;

        if ($contentHeight > 210) {
            $pdf->addPage();
            $pdf->SetY(25);
        }

        $t = 1;

        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->setXY($l + 18, $pdf->GetY() + 5);
        if ($title === 'Indemnification') {
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->MultiCell(0, 0, $title . ': ', 0, 'L', 0, 1, 12, $pdf->GetY(), true, 0, false, true, 0);

            $letter = 'a';
            foreach($contents as $content) {
                foreach ($content as $subtitle) {
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->MultiCell(0, 0, $subtitle, 0, 'L', 0, 1, 20, $pdf->GetY() + 3, true, 0, false, true, 0);
                }
            }
        } else {
            $pdf->MultiCell(0, 0, $pageNo . '.) ' . $title . ': ', 0, 'L', 0, 1, 12, $pdf->GetY(), true, 0, false, true, 0);
            $letter = 'a';
            foreach($contents as $content) {
                foreach ($content as $subtitle => $items) {
                    $pdf->SetFont('helvetica', 'B', 11);
                    if ($subtitle === 'Endorsements') {
                        $pdf->MultiCell(0, 0, $letter . '.) ' . $subtitle . ': ', 0, 'L', 0, 1, 20, $pdf->GetY() + 3, true, 0, false, true, 0);
                    } else {
                        $pdf->MultiCell(0, 0, $letter . '.) ' . $subtitle . ': ', 0, 'L', 0, 1, 20, $pdf->GetY(), true, 0, false, true, 0);
                    }

                    $i = 1;
                    foreach ($items as $item) {
                        $pdf->SetFont('helvetica', '', 11);
                        $pdf->setXY($l + 25, $pdf->GetY());
                        $pdf->MultiCell(0, 0, '<b>' . $this->numberToRomanRepresentation($i) . '.)</b> ' . $item, 0, 'L', 0, 1, 25, $pdf->GetY(), true, 0, true, true, 0);
                        $i++;
                    }
                    $letter++;
                }
            }
        }
    }

    function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    private function generatePdfReport($id) {
        $insuranceNeedsInfo = InsuranceNeeds::select('*')->where('id', $id)->first();
        $fullname = $insuranceNeedsInfo['firstname'] . ' ' . $insuranceNeedsInfo['lastname'];
        $address = $insuranceNeedsInfo['address'] . ' ' . $insuranceNeedsInfo['city'] . ' ' . $insuranceNeedsInfo['state_id'] . ' ' . $insuranceNeedsInfo['zipcode'];
        $trades_ids = json_decode($insuranceNeedsInfo->trades_id, true);

        $pdf = app('tcpdf');

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Pascal Burke');
        $pdf->SetTitle('Insurance Needs Survey');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));

        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 11);

        $l = 12;

        $pdf->setXY($l, 35);
        $pdf->Cell(0, 0, 'August 22, 2023', 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->setXY($l, 47);
        $pdf->Cell(0, 0, $fullname, 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->setXY($l, 53);
        $pdf->Cell(0, 0, $insuranceNeedsInfo['company_name'], 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->setXY($l, 59);
        $pdf->Cell(0, 0, $address, 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->setXY($l, 65);
        $pdf->Cell(0, 0, $insuranceNeedsInfo['phone_no'], 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->setXY($l, 80);
        $pdf->Cell(0, 0, 'Re: Contractors Insurance Needs Survey Report', 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->setXY($l, 100);
        $pdf->Cell(0, 0, 'Dear ' . $insuranceNeedsInfo['firstname'] . ', ', 0, 0, 'L', 0, 0, 0, false, '', '');

        $html = "
            <div>Thank you for completing the Insurance Survey for the <b>“Contractors Insurance Needs Survey“</b>.</div>
            <div>The purpose of the <b>Insurance Needs Survey</b> is to provide you with a preliminary report of the exposures to your company and identify the insurance needed to protect your company from loss.</div>
            <div>The <b>Pascal Burke Insurance Brokerage</b>, is a premier in commercial insurance agency, specializing insurance for the construction industry. Prior to making a decision regarding purchasing of any insurance, we recommend that you speak with a licensed commercial insurance agent.</div>
            <div>Please feel free to give us a call at <b>(877) 893-7629</b>, or go on website at <b>https://pbibins.com/</b> or if you prefer go to <b>https://quote.pbibins.com/</b> and complete a simple online questionnaire, to receive an insurance quote.</div>
            <div>We look forward to working with you on your insurance needs,</div>
            <br />
            <div>Sincerely,</div>
        ";

        $pdf->MultiCell(0, 0, $html, 0, 'L', 0, 1, $l + 3, $pdf->GetY() + 15, true, 0, true, true, 0);

        $pascal_signature = public_path('img/pascal-sign.png');
        $pdf->Image($pascal_signature, $l, 200, 45, 15, 'png', '', 'L', false, 300, '', false, false, 1, false, false, false);

        $pascal_e_signature = public_path('img/pascal_signature.png');
        $pdf->Image($pascal_e_signature, $l, $pdf->GetY() + 17, 70, 30, 'png', '', 'L', false, 300, '', false, false, 0, false, false, false);

        // Start here
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 11);

        $pdf->setXY($l, 25);
        $pdf->SetFillColor(6, 67, 103);
        $pdf->Rect(10, $pdf->GetY(), $pdf->GetPageWidth() - 20, 10, 'F');

        $pdf->Ln(4);

        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 0, 'ABC Company', 0, 0, 'C', 0, 0, 0, false, 'C', 'M');

        $pdf->SetFont('helvetica', 'B', 17);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->setXY($l, 40);
        $pdf->Cell(0, 0, 'Insurance Needs Survey - Report', 0, 0, 'L', 0, 0, 0, false, '', '');

        $pdf->SetFont('helvetica', 'B', 12);

        $pdf->setXY($l + 5, $pdf->GetY() + 15);
        $pdf->Cell(0, 0, '1. You selected the following Trade(s):', 0, 0, 'L', 0, 0, 0, false, '', '');
        $pdf->setXY($l, $pdf->GetY() + 3);

        $mt = 30;
        foreach ($trades_ids as $trade_id) {
            $trade = Trades::find($trade_id);

            if ($pdf->GetY() > 220) {
                $pdf->addPage();
                $pdf->SetY($mt);
            }

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->setXY($l + 5, $pdf->GetY() + 5);

            $html = "<ul><li>{$trade->tradename}</li></ul>";
            if ($trade['tradename'] === 'Plumbing Contractor') {
                $currentHeight = $pdf->GetY();
                if ($currentHeight > 200) {
                    $pdf->addPage();
                    $pdf->SetY($mt);
                }
            }

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->SetFont('helvetica', '', 11);

            if ($trade->gl_iso) {
                $pdf->MultiCell(0, 0, chr(45) . ' ' . $trade->gl_iso, 0, 'L', 0, 1, 30, $pdf->GetY(), true, 0, false, true, 0);
            }

            $html = " {$trade->description} ";
            $pdf->MultiCell(0, 0, chr(45) . ' ' . $html, 0, 'L', 0, 1, 30, $pdf->GetY(), true, 0, true, true, 0);
        }

        // 2 - 16 Questions
        // $fullWidth = $pdf->getPageWidth();
        // $headerWidth = $pdf->getHeaderMargin();
        // $footerWidth = $pdf->getFooterMargin();
        // $totalWidth = $fullWidth - $headerWidth - $footerWidth;

        if ($insuranceNeedsInfo['does_perform_residential_work']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend for all contractors General Liability Insurance with a minimum policy limit of $1,000,000 per occurrence, $2,000,000 aggregate, and $1,000,000 completed operations',
                    'REAL-WORLD REQUIREMENTS: If you are working for a general contractor or a real estate developer, they will require the following endorsements: Named Additional Insured, Primary Noncontributory, and a Waiver of Subrogation. Note: ISO Endorsements are always preferred and maybe required.',
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='2. Do you perform any residential work?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    '',
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='2. Do you perform any residential work?', $contents);
        }

        if ($insuranceNeedsInfo['does_perform_commercial_work']) {
            $contents = [
                [
                    'You answered "YES"',
                    'REAL-WORLD REQUIREMENTS: You selected that you are performing “Commercial Work”. Most commercial projects require that you carry General Liability, Workers Compensation and Commercial Auto. You may also need to the following endorsements: Named Additional Insured (CG 2010), Primary Noncontributory (CG 2001), and a Waiver of Subrogation (CG 2404), and Completed Operations (CG 2037).',
                    '',
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='3. Do you perform any commercial work?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    '',
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='3. Do you perform any commercial work?', $contents);
        }

        if ($insuranceNeedsInfo['does_have_employee']){
            $contents = [
                [
                    'You answered "YES"',
                    'REAL-WORLD REQUIREMENTS: You selected that you are performing “Commercial Work”. Most commercial projects require that you carry General Liability, Workers Compensation and Commercial Auto. You may also need to the following endorsements: Named Additional Insured (CG 2010), Primary Noncontributory (CG 2001), and a Waiver of Subrogation (CG 2404), and Completed Operations (CG 2037).',
                    'We recommend Employment Practices Liability Insurance (EPLI) to all companies with employees. EPLI insurance, protects employers form Sexual harassment, Wrongful termination, Breach of an employment contract, Discrimination, Negligent HR decisions, Inaccurate employee evaluations, Violation of local and federal employment laws, Infliction of emotional distress or mental anguish, Failure to employ or promote, Wrongful discipline or demotion, Mismanagement of employee benefits, Defamation of character and Privacy violations.',
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='4. Do you have employees?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    '',
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='4. Do you have employees?', $contents);
        }

        if ($insuranceNeedsInfo['does_use_vehicle_in_work']){
            $contents = [
                [
                    'You answered "YES"',
                    'We therefore recommend $1,000,000 single limit, including Hired and Non-Owned Auto, Uninsured and Underinsured Motorist coverages.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='5. Do you use a vehicle in your work?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='5. Do you use a vehicle in your work?', $contents);
        }

        if ($insuranceNeedsInfo['does_use_vehicle_in_work']) {
            $contents = [
                [
                    'You answered "YES"',
                    'This creates a loss exposure for your company. We therefore recommend a Business Auto Policy, with $1,000,000 single limit, including Hired, Non-owned auto, underinsured motorist and underinsured motorist coverages.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='6. Do your employees if any use their own vehicle for their work?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='6. Do your employees if any use their own vehicle for their work?', $contents);
        }

        if ($insuranceNeedsInfo['does_work_property_above_1m']) {
            $contents = [
                [
                    'You answered "YES"',
                    'You may consider an excess liability policy if the work you perform can lead to catastrophic loss, such as fire. Excess liability is sold in $1,000,000 increment to meet your needs.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='7. Do you work on property with a value greater than $1,000,000?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='7. Do you work on property with a value greater than $1,000,000?', $contents);
        }

        if ($insuranceNeedsInfo['does_rent_equipment_or_add_up_10k']) {
            $contents = [
                [
                    'You answered "YES"',
                    'Tools & Equipment coverage is based upon the value of your tools & equipment, it provides coverage while in storage, in transit or at the jobsite. Remember that you must always secure your tools and equipment, by locking them while in your vehicle or while being stored.',
                    'If you frequently rent equipment, compare the cost of purchasing an Equipment Floater from PBIB, or using the insurance provided by the rental company, depending on frequency and duration you could save a lot of money.'
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='8. Do your tools and equipment add up to more than $10,000?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='8. Do your tools and equipment add up to more than $10,000?', $contents);
        }

        if ($insuranceNeedsInfo['does_rent_office_other_than_home']) {
            $contents = [
                [
                    'You answered "YES"',
                    'You will need a property policy based upon the value of the property that we are protecting. Also, premise liability, to protect from 3rd party injury while at your property.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='9. Do you own or rent an office, warehouse, or yard facility other than your home?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='9. Do you own or rent an office, warehouse, or yard facility other than your home?', $contents);
        }

        if ($insuranceNeedsInfo['are_you_gc_performs_remodeling']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend a builder’s risk policy based upon the value of the construction.',
                    'Please note:'
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='10. Are you a General Contractor that performs remodel, additions, or new ground up construction for residential or commercial building?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='10. Are you a General Contractor that performs remodel, additions, or new ground up construction for residential or commercial building?', $contents);
        }

        if ($insuranceNeedsInfo['does_transport_materials_above_10k']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend an Installation Floater, that will cover the replacement cost of these materials while in transit, or stored at your facility, or jobsite.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='11. Do you transport materials, and or store them at your facility or jobsite, with a value greater than $10,000?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='11. Do you transport materials, and or store them at your facility or jobsite, with a value greater than $10,000?', $contents);
        }

        if ($insuranceNeedsInfo['does_perform_design_bldg_for_fee']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend Professional Liability Insurance to protect your company for claims as a result of you rendering of, or failure to render, errors and omission of professional services, this coverage will provide defense and indemnity.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='12. Do you perform any of the following services: Design Build, architectural, engineering services or construction management for a fee?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='12. Do you perform any of the following services: Design Build, architectural, engineering services or construction management for a fee?', $contents);
        }

        if ($insuranceNeedsInfo['does_your_website_collect_personal_info']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend Cyber Liability Insurance will provide legal defense and indemnity for Information security liability, Privacy liability, Content liability and Bodily injury and property damage liability.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='13. Do collect any personal information from your customers; credit card information, phone number, address, checking account, driver’s license, social security, date of birth?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='13. Do collect any personal information from your customers; credit card information, phone number, address, checking account, driver’s license, social security, date of birth?', $contents);
        }

        if ($insuranceNeedsInfo['does_your_website_collect_personal_info']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend Cyber Liability Insurance will provide legal defense and indemnity for Information security liability, Privacy liability, Content liability and Bodily injury and property damage liability.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='14. Do you have a website that collects personal data from site visitors?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='14. Do you have a website that collects personal data from site visitors?', $contents);
        }

        if ($insuranceNeedsInfo['does_store_transport_pollutants']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We recommend Pollution Liability insurance will provide legal defense and indemnity for bodily injury and property damage.',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='15. Do you store, transport, or use on the jobsite any pollutants?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='15. Do you store, transport, or use on the jobsite any pollutants?', $contents);
        }

        if ($insuranceNeedsInfo['does_use_subcontractors']) {
            $contents = [
                [
                    'You answered "YES"',
                    'We therefore recommend that all subcontractors execute a Subcontractors Agreement with the following sections, to transfer risk to the subcontractor.',
                    'The following are elements needed in a subcontractor agreement,'
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='16. Do you use subcontractors?', $contents);
        } else {
            $contents = [
                [
                    'You answered "NO"',
                    '',
                    ''
                ]
            ];
            $this->calculateQuestionsSection($pdf, $l=12, $title='16. Do you use subcontractors?', $contents);
        }

        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);

        $pdf->setXY($l + 5, $pdf->GetY() + 17);
        $pdf->MultiCell(100, 0, 'ELEMENTS OF A SUBCONTRACTOR AGREEMENT', 0, 'C', 0, 1, $l + 50, $pdf->GetY() + 5, true, 0, false, true, 0);

        $pdf->SetFont('helvetica', 'I', 11);

        $pdf->MultiCell(0, 0, "Note: The primary elements of the subcontractor agreement for the transfer of risk to the subcontractor is the Insurance Requirements and the indemnity or hold harmless agreement.", 0, 'L', 0, 1, 12, $pdf->GetY() + 5, true, 0, false, true, 0);

        // Initialize dynamic page number
        $dynamicPageNo = 1;

        if ($insuranceNeedsInfo->does_perform_residential_work != 0 || $insuranceNeedsInfo->does_perform_commercial_work != 0) {
            $contents =
                [
                    [
                        'Limits of Liability' => [
                            '$1,000,000 per Occurrence.',
                            '$2,000,000 General Aggregate.',
                            '$2,000,000 Aggregate for Products-Completed Operations.',
                            '$1,000,000 Personal & Advertising injury.',
                        ]
                    ],
                    [
                        'Endorsements: Subcontractor shall name the Contractor additional Insured and schedule the contractor on the following endorsements' => [
                            'Named Additional Insured Endorsement CG 2010, or equivalent).',
                            'Waiver of Subrogation (CG 2404, or equivalent).',
                            'Primary Non-Contributory (CG 2001 or equivalent).',
                            'Completed Operations (CG 2037, or equivalent) (available for commercial work only).',
                        ]
                    ]

                ];
            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l=12, $title='General Liability', $contents);
            $dynamicPageNo++;
        }

        if ($insuranceNeedsInfo->does_have_employee != 0) {
            $contents =
                [
                    [
                        'Limits of Liability' => [
                            '$1,000,000 General Aggregate.',
                            '$1,000,000 Each Occurrence.',
                            '$1,000,000 Employers Liability.',
                        ]
                    ],
                ];
            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l=12, $title='Worker\'s Compensation', $contents);
            $dynamicPageNo++;
        }

        if ($insuranceNeedsInfo->does_use_vehicle_in_work != 0) {
            $contents =
                [
                    [
                        'Limits of Liability' => [
                            '$1,000,000 Single Limits.',
                        ]
                    ],
                    [
                        'Endorsements' => [
                            'Hired & Non-Owned Auto.',
                            'Uninsured Motorist and Underinsured Motorist.',
                            '(Symbol 1 or Symbols 7, 8 & 9).',
                        ]
                    ],

                ];
            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Commercial Auto', $contents);
            $dynamicPageNo++;
        }

        if ($insuranceNeedsInfo->does_work_property_above_1m != 0) {
            $contents =
                [
                    [
                        '$1,000,000 Limits (* See note below)' => [
                            'Note: Excess Liability should be considered for exposures to loss that exceed $1,000,000, or contractual requirements that dictate the amount of excess liability that must be carried.',
                            '$1,000,000 or contractual requirements that dictate the amount of excess liability that must be carried.',
                        ]
                    ],
                ];

            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Excess Liability', $contents);
            $dynamicPageNo++;
        }


        if ($insuranceNeedsInfo->does_rent_equipment_or_add_up_10k != 0) {
            $contents =
                [
                    [
                        '$10,000 Limits (* See note below)' => [
                            'Note: Tools and Equipment limits should be adjusted to the actual value of the tools and equipment owned, leased, or rented by the contractor.',
                        ]
                    ],
                ];

            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Tools & Equipment', $contents);
            $dynamicPageNo++;
        }

        if ($insuranceNeedsInfo->does_perform_design_bldg_for_fee != 0) {
            $contents =
                [
                    [
                        'Limits of Liability' => [
                            '$1,000,000 per Occurrence.',
                            '$1,000,000 General Aggregate.',
                        ]
                    ],
                ];

            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Professional Liability', $contents);
            $dynamicPageNo++;
        }

        if ($insuranceNeedsInfo->does_your_website_collect_personal_info != 0) {
            $contents =
                [
                    [
                        'Limits of Liability' => [
                            '$1,000,000 per Occurrence.',
                            '$1,000,000 General Aggregate',
                        ]
                    ],
                ];

            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Cyber Liability Insurance', $contents);
            $dynamicPageNo++;
        }

        // $contents =
        //     [
        //         [
        //             'Limits of Liability' => [
        //                 '$1,000,000 per Occurrence.',
        //                 '$2,000,000 General Aggregate.',
        //             ]
        //         ],
        //     ];

        // $this->calculateElSubconAgreement($pdf, $pageNo=8, $l, $title='Employment Practices Liability Insurance (EPLI)', $contents);

        if ($insuranceNeedsInfo->does_store_transport_pollutants != 0) {
            $contents =
                [
                    [
                        'Limits of Liability' => [
                            '$1,000,000 per Occurrence.',
                            '$2,000,000 General Aggregate.',
                        ]
                    ],
                ];

            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Pollution Liability Insurance', $contents);
            $dynamicPageNo++;
        }

        if ($insuranceNeedsInfo->does_use_subcontractors != 0) {
            $contents =
                [
                    [
                        'To the fullest extent permitted by law, Subcontractor shall defend, indemnify and hold harmless the Client and Contractor along with any of their agents, employees, or individuals associated with their organization from claims, demands, causes of actions and liabilities of any kind and nature whatsoever arising out of or in connection with the Subcontractor’s Services or operations performed under this Agreement and causes or alleged to be caused, in whole or in part, by any act or omission of the Subcontractor or anyone employed directly or indirectly by Subcontractor or on Subcontractor’s account related to Subcontractor’s Services hereunder. This indemnification shall extend to claims occurring after this Agreement is terminated as well as while it is in force. The indemnity shall apply regardless of any passively negligent act or omission of the Client or Contractor, or their agents or employees, but Subcontractor shall not be obligated to indemnify any party for claims arising from the active negligence, sole negligence, or willful misconduct of Client or Contractor or their agents or employees or arising solely by the designs provided by such parties. To the extent that State law limits the defense or indemnity obligations of the Subcontractor either to Contractor or Client, the intent here under is to provide the maximum defense and indemnity obligations allowed by the Subcontractor under the law. The indemnity set forth in this Section shall not be limited by any insurance requirement or any other provision of this Agreement.'
                    ],
                ];

            $this->calculateElSubconAgreement($pdf, $dynamicPageNo, $l, $title='Indemnification', $contents);
            $dynamicPageNo++;
        }

        $currentY = $pdf->GetY();
        $topMargin = $pdf->getMargins()['top'];
        $contentHeight = $currentY - $topMargin;

        if ($contentHeight > 210) {
            $pdf->addPage();
            $pdf->SetY(25);
        }

        $pdf->MultiCell(0, 0,'<b>Other insurance we recommend for “Commercial Contractors”</b>', 0, 'L', 0, 1, $l, $pdf->GetY() + 5, true, 0, true, true, 0);
        $pdf->MultiCell(0, 0,'REAL-WORLD REQUIREMENTS: You selected that you are performing “Commercial Work”. Most commercial projects require that you carry General Liability, Workers Compensation and Commercial Auto. You may also need to the following endorsements: Named Additional Insured (CG 2010), Primary Noncontributory (CG 2001, and a Waiver of Subrogation (CG 2404) and Completed Operations (CG 2037).', 0, 'L', 0, 1, $l, $pdf->GetY() + 3, true, 0, true, true, 0);

        $currentY = $pdf->GetY();
        $topMargin = $pdf->getMargins()['top'];
        $contentHeight = $currentY - $topMargin;

        if ($contentHeight > 210) {
            $pdf->addPage();
            $pdf->SetY(25);
        }

        $lineWidth = 190;
        $lineHeight = 1;

        $startX = ($pdf->GetPageWidth() - $lineWidth) / 2;
        $endX = $startX + $lineWidth;

        $y = $pdf->GetY() + 5;

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth($lineHeight);
        $pdf->Line($startX, $y, $endX, $y);

        $pdf->MultiCell(0, 0,'<b>Disclaimer: This report is for informational purposes only, and preliminary in nature, and all recommendations contained herein are for a purpose of building insurance awareness, and are not intended to be conclusive insurance recommendations, and should not be relied upon as such, but as a preliminary guide for discussion with a licensed broker prior to purchasing any insurance mentioned or recommended in this report.</b>', 0, 'L', 0, 1, $l, $pdf->GetY() + 10, true, 0, true, true, 0);

        $startX = ($pdf->GetPageWidth() - $lineWidth) / 2;
        $endX = $startX + $lineWidth;

        $y = $pdf->GetY() + 5;

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth($lineHeight);
        $pdf->Line($startX, $y, $endX, $y);

        $currentY = $pdf->GetY();
        $topMargin = $pdf->getMargins()['top'];
        $contentHeight = $currentY - $topMargin;

        if ($contentHeight > 210) {
            $pdf->addPage();
            $pdf->SetY(25);
        }

        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->setXY($l, $pdf->GetY() + 5);
        $pdf->MultiCell(0, 0, 'Insurance Needs Survey Notes:', 0, 'L', 0, 1, $l + 5, $pdf->GetY() + 5, true, 0, false, true, 0);

        $pdf->SetFont('helvetica', '', 11);
        // $pdf->setXY($l +, $pdf->GetY() + 5);

        $pdf->MultiCell(0, 0, chr(97) . '.)' . ' Your answers to the insurance survey indicated that you may not have an immediate need for other insurances not detailed above, we however always recommend that contractors carry as a minimum General Liability, Workers Compensation and Commercial Auto insurance', 0, 'L', 0, 1, 20, $pdf->GetY(), true, 0, false, true, 0);
        $pdf->MultiCell(0, 0, chr(98) . '.)' . ' Equivalent endorsements should be approved by your customer prior to purchasing.', 0, 'L', 0, 1, 20, $pdf->GetY(), true, 0, false, true, 0);

        $directory = public_path('generated-pdfs/'.$id);
        if (!File::isDirectory($directory)){
            File::makeDirectory($directory, 0777, true, true);
        }

        $pdf->Output($directory.'/Insurance Needs Survey - '.$insuranceNeedsInfo->company_name.'.pdf', 'F');
        // $pdf->Output('insurance_survey.pdf', 'I');
    }

    private function sendInsuranceNeedsEmail($id, $companyName, $templateData, $formattedDateCreated) {
        $html_body = view('insurance-survey.email-template', $templateData)->render();
        // $apiKey = env('SMTP2GO_API_KEY');
        $apiKey = "api-B0CA3DC80C4711ED96EFF23C91C88F4E";
        // $base64 = chunk_split(base64_encode(file_get_contents(public_path('generated-pdfs/'.$id.'/*.pdf'))));

        $file_path = public_path('generated-pdfs/'.$id.'/Insurance Needs Survey - '.$companyName.'.pdf');

        if (file_exists($file_path)) {
            $file_contents = file_get_contents($file_path);
            if ($file_contents !== FALSE) {
                $base64 = base64_encode($file_contents);
                // Now $base64 is ready to be passed over the API
            } else {
                // Handle read error here
            }
        } else {
            // Handle file not found error here
            Log::error("File does not exist: " . $file_path);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.smtp2go.com/v3/email/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "api_key" => $apiKey,
                "custom_headers" => [
                    [
                        "header" => "Reply-To",
                        "value" => "PBIBINS Contractor Insurance Needs Survey Form <web@pbibinc.com>"
                    ]
                ],
                "html_body" => $html_body,
                "sender" => "PBIBINS Contractor Insurance Needs Survey Form <web@pbibinc.com>",
                "subject" => "PBIBINS Contractor Insurance Needs Survey Form Details - {$formattedDateCreated}",
                "attachments" => array(
                    0 => array(
                        "filename" => 'Insurance Needs Survey - ' . $companyName . '.pdf',
                        "fileblob" => $base64,
                        "mimetype" => "application/pdf"
                    )
                    ),
                "to" => [
                    "rj@pbibinc.com <rj@pbibinc.com>"
                ]
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);
        Log::info('SMTP2GO Response:', $response);
    }
}