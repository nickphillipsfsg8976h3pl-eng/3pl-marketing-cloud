var errorUrl = 'https://cloud.my.3plearning.com/trialerror';
var ParentURL = 'https://www.3plearning.com/software/readiwriter/coming-soon-for-home/';
var MathleticsParentURL = 'https://www.mathletics.com/for-home/free-trial/parents/';
var ReadingEggsParentURL = 'https://readingeggs.com.au/hpcbv/';
var MathSeedsParentURL = 'https://mathseeds.com.au/parents/signup/';

var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);
var pidString = urlParams.get('pid')
var formString = urlParams.get('form')
var pid = pidString.toLowerCase()
var formURLField = formString.toLowerCase()


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
