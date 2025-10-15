var errorUrl = 'https://cloud.my.3plearning.com/trialerror';
var ParentURL = 'https://www.3plearning.com/software/readiwriter/coming-soon-for-home/';
var MathleticsParentURL = 'https://www.mathletics.com/for-home/free-trial/parents/';
var ReadingEggsParentURL = 'https://readingeggs.com/parents/signup/';
var MathSeedsParentURL = 'https://mathseeds.com.au/parents/signup/';

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var pidString = urlParams.get('pid')
var formString = urlParams.get('form')
var pid = pidString ? pidString.toLowerCase() : "";
var formURLField = formString ? formString.toLowerCase() : "";



// for (const key of urlParams.entries()) {
//     console.log(key);
//     console.log(urlParams.has('type'));
// }

$(function(){
  // bind change event to select
  $("#job_title_select").on('change', function () {
      var inputFieldValue = $(this).val(); // get selected value

      if (pid == 'mathletics' && (inputFieldValue == "Student" || inputFieldValue == "Parent" || inputFieldValue == "Home schooling parent") && formURLField != "tof") { // require a URL
         // alert(inputFieldValue) // redirect
          window.parent.location.href = MathleticsParentURL;
      }
      else if (pid == 'readingeggs' && (inputFieldValue == "Student" || inputFieldValue == "Parent" || inputFieldValue == "Home schooling parent") && formURLField != "tof") {
      window.parent.location.href = ReadingEggsParentURL;
    }
      else if ( pid == 'mathseeds' && (inputFieldValue == "Student" || inputFieldValue == "Parent" || inputFieldValue == "Home schooling parent") && formURLField != "tof") {
      window.parent.location.href = MathSeedsParentURL;
    }
      else if ( !urlParams.has('pid') && (inputFieldValue == "Student" || inputFieldValue == "Parent" || inputFieldValue == "Home schooling parent") && formURLField != "tof") {
      window.parent.location.href = errorUrl;
    }
      else 
      {
  //  alert("Retrieve job title date failed. Customer Type has an invalid value: " + customerType);
  //  window.location.href = errorUrl;

      }
  })
})
// });


// function jobTitleChanged() {
//   var selectedJobTitle = $("#job_title_select").val();
//   var jobTitleURL = "https://web.my.3plearning.com/commonFormScript_02/?jobTitle=" + selectedJobTitle;
//  // var productID = document.getElementById("product_interest_select").value;  

//   $.ajax({
//    url: jobTitleURL,
//    async: true,
//    success: function(result, status, xhr) {
//   var jobTitleJSONData = result.substring(result.indexOf("<rs1>") + 5, result.indexOf("</rs1>"));
//   var data_jobTitle = JSON.parse(jobTitleJSONData);

//   // depending on jobtitle only one record will return, if can not find record or there are more than 
//   // one record in data extension, will redirect to error page from globalForm_processing

//   var customerType = data_jobTitle[0]["Customer Type"];
//  // console.log(data_jobTitle)
//   if (customerType == "School") {
//     $("#divEnquirySelectHomeUser").hide();
//     $("#divSchoolName").show();
//     $("#divEnquirySelectSchoolUser").show();
//     $("#enquiry-select-school-user").val("");
//   }
//   else if (customerType == "Home" ) {
//     window.parent.location.href = ReadingEggsParentURL;
//     }

// //   else if (customerType == "Home") {
// //     $("#divSchoolName").hide();
// //     $("#divEnquirySelectSchoolUser").hide();
// //     $("#divEnquirySelectHomeUser").show();
// //     $("#enquiry-select-home-user").val("");
// // window.parent.location.href = WordFlyersParentURL;
// //   }
//   else {
//   //  alert("Retrieve job title date failed. Customer Type has an invalid value: " + customerType);
//    window.location.href = errorUrl;
//   }
//    },
//    error: function(xhr, status, error) {
//   alert("Retrieve job title date failed. Statue: " + status + "; Error: " + error);
//  // console.log("Not working ");
//    window.location.href = errorUrl;
//    }
//   });
// }

//
