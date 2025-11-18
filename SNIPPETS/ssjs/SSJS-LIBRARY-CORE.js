<script runat="server" language="javascript">
    //  NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
    // 
    //  USE YOUR OWN COPY. IT IS EXTREMELY UNWISE TO LOAD CODE FROM SERVERS YOU DO
    //  NOT CONTROL.
    // 
    // Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
    // documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
    // the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
    // and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    // 
    // The above copyright notice and this permission notice shall be included in all copies or substantial portions 
    // of the Software.
    // 
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED 
    // TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
    // THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
    // CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
    // DEALINGS IN THE SOFTWARE.

    /**
     * Enables the AMP function HTTPRequestHeader in SSJS
     *
     * This function returns a specified header from an HTTP request. This function 
     * is only available in landing pages, microsites and CloudPages. It cannot be used 
     * in other Marketing Cloud applications.
     *
     * NOTE: Only headers that are available in the page request return a value. For example, 
     * if a user pastes a URL into a web browser instead of clicking on a page hyperlink 
     * (from another web page), the Referer header value will be empty.
     *
     * @param  {string}    key  An HTTP header as defined in {@link https://tools.ietf.org/html/rfc7231|RFC 7231}
     *
     * @see {@link https://ampscript.guide/httprequestheader/|HTTPRequestHeader}
     */
  
    function HTTPRequestHeader(key) {
        var varName = '@amp__HTTPRequestHeader';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = HTTPRequestHeader(";
        // parameter
        amp += "'" + key + "'";
        // function close
        amp += ") ";
        // output
        amp += "output(v("+varName+"))";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
    }

    /**
     * Enables the AMP function UpdateSingleSalesforceObject in SSJS
     *
     * This function updates a record in a Sales or Service Cloud standard or 
     * custom object. The function returns 1 if the record is updated successfully 
     * or 0if it fails.
     *
     * NOTE: Additional API field name and value pairs can be appended as arguments.
     *
     * NOTE: Certain Salesforce objects enforce record-locking when a record is modified,
     * to ensure the referential integrity of data. This applies to records that have a 
     * relationship to lookup records in a different object. If the function is used to 
     * asynchronously update multiple records (for example, the function is included in 
     * an email) and the object has lock contention, the records may fail to update.
     *
     * @param  {string}    sfObject        API name of the Salesforce object.
     * @param  {string}    id              Record identifier to update
     * @param  {array}     parameters      Array of name-valiue pair to update
     *
     * @see {@link https://ampscript.guide/updatesinglesalesforceobject/|UpdateSingleSalesforceObject}
     */
    function UpdateSingleSalesforceObject(sfObject,id,parameters) {
        var varName = '@amp__UpdateSingleSalesforceObject';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = UpdateSingleSalesforceObject(";
        // parameters
        amp += "'" + sfObject + "'";
        amp += ",'" + id + "'";
        // n parameters to update
        for( var k in parameters ) {
            amp += ",'"+k+"','"+parameters[k]+"'";
        }
        // function close
        amp += ") ";
        // output
        amp += "output(v("+varName+"))";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
    }

    /**
     * Enables the AMP function RetrieveSalesforceObjects in SSJS
     *
     * This function retrieves fields from a record in a Sales or Service Cloud 
     * standard or custom object. The function returns a row set of fields.
     *
     * NOTE: Additional API field name, comparison operator and value sets can 
     * be appended as arguments. However the function joins these additional sets using AND clauses.
     *
     * NOTE: This function should only be used in applications that do not require a high volume 
     * of requests or return a large number of records; for example, an email send to a small 
     * audience, a Triggered Send, or the retrieval of a single record on a landing page.
     *
     * NOTE: The function may take several seconds to execute, impacting email send performance 
     * and may result in a timeout if the request volume is high for example; using a process 
     * loop to execute the function multiple times or returning a large number of rows. Unlike 
     * other AMPscript functions that return a row set — for example, LookupRows which limits 
     * the number of rows to 2000 — there is not the same type of limitation on the number of 
     * rows returned by this function.
     * 
     *
     * @param  {string}    sfObject        API name of the Salesforce object.
     * @param  {array}     fieldNames      Comma-separated array of API field names to retrieve
     * @param  {array}     parameters      Set of arrays where each array is one set of filter
     *                                     <br/>1: API field name to match record
     *                                     <br/>2: Comparison operator for matching records. Valid operators include:
     *                                        <br/> = equal to
     *                                        <br/> < less than
     *                                        <br/> > greater than
     *                                        <br/> != not equal to
     *                                        <br/> <= less than or equal to
     *                                        <br/> >= greater than or equal to
     *                                     <br/>3: Value to match record using comparison operator in 2
     *
     * @returns {object} The result of the request
     *
     * @see {@link https://ampscript.guide/retrievesalesforceobjects/|RetrieveSalesforceObjects}
     */
    function RetrieveSalesforceObjects(sfObject,fieldNames,parameters) {
        var varName = '@amp__RetrieveSalesforceObjects';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "SET "+varName+" = RetrieveSalesforceObjects(";
        // parameters
        amp += "'" + sfObject + "'";
        amp += ",'" + fieldNames.join(",") + "'";
        // n parameters to update
        //for (var i = 0; i < parameters.length; i++) {
            amp += ",'" + parameters.join("','") + "'";
        //}
        // function close
        amp += ") ";

        // build json from rowset
        amp += "SET "+varName+"_output = '{ \"Status\": \"OK\", \"Results\": [' ";

        // iterate over RowCount
        amp += "FOR "+varName+"_i = 1 TO RowCount("+varName+") DO ";
        amp += "SET "+varName+"_output = Concat("+varName+"_output,'{') ";

        // iterate over each fieldNames
        for (var n = 0; n < fieldNames.length; n++) {
            amp += "SET "+varName+"_output = Concat("+varName+"_output,'\""+fieldNames[n]+"\":\"', Field(Row("+varName+", "+varName+"_i) ,'"+fieldNames[n]+"',0),'\"') ";
            amp += (n<(fieldNames.length-1)) ? "SET "+varName+"_output = Concat("+varName+"_output,', ') " : " ";
        }
        
        // close for loop
        amp += "SET "+varName+"_output = Concat("+varName+"_output,'}') ";
        amp += "IF "+varName+"_i < RowCount("+varName+") THEN SET "+varName+"_output = Concat("+varName+"_output,',') ENDIF ";
        amp += "NEXT "+varName+"_i ";

        // close ouput object
        amp += "SET "+varName+"_output = Concat("+varName+"_output,'] }') ";

        // output
        amp += "Output(v("+varName+"_output)) ";
        // end of AMP
        amp += "]\%\%";

        try {
            return Platform.Function.ParseJSON(Platform.Function.TreatAsContent(amp)); 
        } catch(e) {
            return Platform.Function.ParseJSON('{"Status": "Error cannot retrieve Salesforce Object", "Results": ['+Platform.Function.Stringify(amp)+']}');
        }
    }

    /**
     * Enables the AMP function CloudPagesURL in SSJS
     *
     * Provides a way for users to reference a CloudPages URL in an account from an email message. 
     * Use this function in an email to pass information via a URL in an encrypted query string. 
     * For example, you could share a single unsubscription or profile center page for use in 
     * any sent email message. This method passes information in an encrypted query string without 
     * passing subscriber information or values in clear text.
     *
     * @param  {integer}   pid         Page ID for the landing page reference in the URL. 
     *                                 Locate this value on the appropriate CloudPage content 
     *                                 details page. Page ID can be from the enterprise (EID) 
     *                                 or the business unit (MID) where the function is used. 
     * @param  {object}    parameters  Name-Value pair for additional parameters included
     *                                 in encrypted query string
     *
     * @returns {string} A full URL 
     */
    function CloudPagesURL(pid,parameters) {
        var varName = '@amp__CloudPagesURL';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = CloudPagesURL(";
        // parameters
        amp += "'" + pid + "'";
        // n parameters
        for( var k in parameters ) {
            amp += ",'"+k+"','"+parameters[k]+"'";
        }
        // function close
        amp += ") ";
        // output
        amp += "output(concat("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
    }

    /**
     * Enables the AMP function SHA1 in SSJS
     *
     * This function converts the specified string into a SHA1 hex value hash.
     *
     *
     * @param  {string}    string               String to convert
     * @param  {string}    [encoding=UTF-8]     Character set to use for character-encoding. 
     *                                          Valid values are UTF-8 (default) and UTF-16
     *
     * @returns {string}    The string as a SHA1 hex value hashed
     */
     function SHA1(string,encoding) {
        var varName = '@amp__SHA1';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = SHA1(";
        // parameters
        amp += "'" + string + "'";
        if(encoding) {
            amp += "'" + encoding + "'";
        }
        // function close
        amp += ") ";
        // output
        amp += "output(v("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
     }

    /**
     * Enables the AMP function SHA256 in SSJS
     *
     * This function converts the specified string into a SHA256 hex value hash.
     *
     *
     * @param  {string}    string               String to convert
     * @param  {string}    [encoding=UTF-8]     Character set to use for character-encoding. 
     *                                          Valid values are UTF-8 (default) and UTF-16
     *
     * @returns {string}    The string as a SHA256 hex value hashed
     */
     function SHA256(string,encoding) {
        var varName = '@amp__SHA256';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = SHA256(";
        // parameters
        amp += "'" + string + "'";
        if(encoding) {
            amp += "'" + encoding + "'";
        }
        // function close
        amp += ") ";
        // output
        amp += "output(concat("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
     }

    /**
     * Enables the AMP function SHA512 in SSJS
     *
     * This function converts the specified string into a SHA512 hex value hash.
     *
     *
     * @param  {string}    string               String to convert
     * @param  {string}    [encoding=UTF-8]     Character set to use for character-encoding. 
     *                                          Valid values are UTF-8 (default) and UTF-16
     *
     * @returns {string}    The string as a SHA512 hex value hashed
     */
     function SHA512(string,encoding) {
        var varName = '@amp__SHA512';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = SHA512(";
        // parameters
        amp += "'" + string + "'";
        if(encoding) {
            amp += "'" + encoding + "'";
        }
        // function close
        amp += ") ";
        // output
        amp += "output(concat("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
     }

    /**
     * Enables the AMP function DataExtensionRowCount in SSJS
     *
     * This function returns the number of rows in the specified Data Extension.
     *
     * NOTE: This function will not return row counts from the {@link http://help.marketingcloud.com/en/documentation/automation_studio/using_automation_studio_activities/using_the_query_activity/data_views/|System Data Views.}
     *
     * @param {string} dataExtensionName     Name of the Data Extension from which to retrieve a row count
     *
     * @see {@link https://ampscript.guide/dataextensionrowcount/|DataExtensionRowCount}
     */
     function DataExtensionRowCount(dataExtensionName) {
        var varName = '@amp__DataExtensionRowCount';

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = DataExtensionRowCount(";
        // parameters
        amp += "'" + dataExtensionName + "'";
        // function close
        amp += ") ";
        // output
        amp += "output(concat("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
     }

    /**
     * Enables the AMP function EncryptSymmetric in SSJS
     *
     * This function encrypts a string with the specified algorithm and qualifiers. Outputs a Base64 encoded value.
     *
     * @param {string} string           String to encrypt
     * @param {string} algorithm        Algorithm used to encrypt the string. Valid values are aes, des, and tripledes
     * @param {string} password_key     Password External Key for retrieval from Key Management
     * @param {string} password         Password value
     * @param {string} salt_key         Salt External Key for retrieval from Key Management
     * @param {string} salt             Salt value as an 8-byte hex string
     * @param {string} vector_key       Initialization vector External Key for retrieval from Key Management
     * @param {string} vector           Initialization vector value as a 16-byte hex string
     *
     * @see {@link https://ampscript.guide/encryptsymmetric|EncryptSymmetric}
     */
     function EncryptSymmetric(string,algorithm,password_key,password,salt_key,salt,vector_key,vector) {
        var varName = '@amp__EncryptSymmetric',
            param = [algorithm,password_key,password,salt_key,salt,vector_key,vector];

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = EncryptSymmetric(";
        // string parameter
        amp += "'" + string + "'";

        for (var i = 0; i < param.length; i++) {
            var value = (param[i]) ? "'"+param[i]+"'" : '@null';
            amp += "," + value;    
        }

        // function close
        amp += ") ";
        // output
        amp += "output(concat("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
    }

    /**
     * Enables the AMP function DecryptSymmetric in SSJS
     *
     * This function decrypts a string with the specified algorithm and qualifiers.
     *
     * @param {string} string           String to decrypt
     * @param {string} algorithm        Algorithm used to encrypt the string. Valid values are aes, des, and tripledes
     * @param {string} password_key     Password External Key for retrieval from Key Management
     * @param {string} password         Password value
     * @param {string} salt_key         Salt External Key for retrieval from Key Management
     * @param {string} salt             Salt value as an 8-byte hex string
     * @param {string} vector_key       Initialization vector External Key for retrieval from Key Management
     * @param {string} vector           Initialization vector value as a 16-byte hex string
     *
     * @see {@link https://ampscript.guide/decryptsymmetric/|DecryptSymmetric}
     */
     function DecryptSymmetric(string,algorithm,password_key,password,salt_key,salt,vector_key,vector) {
        var varName = '@amp__DecryptSymmetric',
            param = [algorithm,password_key,password,salt_key,salt,vector_key,vector];

        // AMP decleration
        var amp = "\%\%[ ";
        // function open        
        amp += "set "+varName+" = DecryptSymmetric(";
        // string parameter
        amp += "'" + string + "'";

        for (var i = 0; i < param.length; i++) {
            var value = (param[i]) ? "'"+param[i]+"'" : '@null';
            amp += "," + value;    
        }

        // function close
        amp += ") ";
        // output
        amp += "output(concat("+varName+")) ";
        // end of AMP
        amp += "]\%\%";

        return Platform.Function.TreatAsContent(amp);
    }  
  
  //  NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
  // 
  //  USE YOUR OWN COPY. IT IS EXTREMELY UNWISE TO LOAD CODE FROM SERVERS YOU DO
  //  NOT CONTROL.
  // 
  // Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
  // documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
  // the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
  // and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
  // 
  // The above copyright notice and this permission notice shall be included in all copies or substantial portions 
  // of the Software.
  // 
  // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED 
  // TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
  // THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
  // CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
  // DEALINGS IN THE SOFTWARE.


  /************************* NUMBER *************************/


  // ECMAScript (ECMA-262)
  Number.isInteger = Number.isInteger || function(value) {
    return typeof value === 'number' && 
      isFinite(value) && 
      Math.floor(value) === value;
  };


  if (Number.parseFloat === undefined) {
      Number.parseFloat = parseFloat;
  }


  /************************* STRING *************************/


  if (!String.prototype.trim) {
      String.prototype.trim = function() {
          return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
      };
  }

  if (!String.prototype.substr) {
      String.prototype.substr = function(a, b) {
          var s = (!Number.isInteger(a)) ? 0 : a,
              l = (typeof b == 'undefined') ? null : (s > 0 && b > 0) ? s + b : b;
          if (s < 0) {
              s = this.length + a;
              l = (l < 0) ? 0 : s + l;
          }
          return (typeof b == 'undefined' && b != 0 && Number.isInteger(a)) ? this.substring(s) : (l <= 0 || !Number.isInteger(l)) ? "" : this.substring(s, l);
      };
  }

  // ECMAScript 2015 specification
  if (!String.prototype.startsWith) {
      Object.defineProperty(String.prototype, 'startsWith', {
          value: function(search, rawPos) {
              var pos = rawPos > 0 ? rawPos|0 : 0;
              return this.substring(pos, pos + search.length) === search;
          }
      });
  }


  // ECMAScript 2015 specification
  if (!String.prototype.includes) {
      String.prototype.includes = function(search, start) {
          'use strict';

          if (search instanceof RegExp) {
              throw TypeError('first argument must not be a RegExp');
          } 
          if (start === undefined) { start = 0; }
          return this.indexOf(search, start) !== -1;
      };
  }



  /************************* Object *************************/


  // From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
  if (!Object.keys) {
    Object.keys = (function() {
      'use strict';
      var hasOwnProperty = Object.prototype.hasOwnProperty,
          hasDontEnumBug = !({ toString: null }).propertyIsEnumerable('toString'),
          dontEnums = [
            'toString',
            'toLocaleString',
            'valueOf',
            'hasOwnProperty',
            'isPrototypeOf',
            'propertyIsEnumerable',
            'constructor'
          ],
          dontEnumsLength = dontEnums.length;

      return function(obj) {
        if (typeof obj !== 'function' && (typeof obj !== 'object' || obj === null)) {
          throw new TypeError('Object.keys called on non-object');
        }

        var result = [], prop, i;

        for (prop in obj) {
          if (hasOwnProperty.call(obj, prop)) {
            result.push(prop);
          }
        }

        if (hasDontEnumBug) {
          for (i = 0; i < dontEnumsLength; i++) {
            if (hasOwnProperty.call(obj, dontEnums[i])) {
              result.push(dontEnums[i]);
            }
          }
        }
        return result;
      };
    }());
  }



  /************************* ARRAY *************************/


  if (!Array.prototype.filter) {
      Array.prototype.filter = function(func, thisArg) {
          'use strict';
          if (!((typeof func === 'Function' || typeof func === 'function') && this))
              throw new TypeError();

          var len = this.length >>> 0,
              res = new Array(len), // preallocate array
              t = this,
              c = 0,
              i = -1;

          var kValue;
          if (thisArg === undefined) {
              while (++i !== len) {
                  // checks to see if the key was set
                  if (i in this) {
                      kValue = t[i]; // in case t is changed in callback
                      if (func(t[i], i, t)) {
                          res[c++] = kValue;
                      }
                  }
              }
          } else {
              while (++i !== len) {
                  // checks to see if the key was set
                  if (i in this) {
                      kValue = t[i];
                      if (func.call(thisArg, t[i], i, t)) {
                          res[c++] = kValue;
                      }
                  }
              }
          }

          res.length = c; // shrink down array to proper size
          return res;
      };
  }


  // Production steps of ECMA-262, Edition 5, 15.4.4.21
  // Reference: http://es5.github.io/#x15.4.4.21
  // https://tc39.github.io/ecma262/#sec-array.prototype.reduce
  if (!Array.prototype.reduce) {
    Object.defineProperty(Array.prototype, 'reduce', {
      value: function(callback /*, initialValue*/) {
        if (this === null) {
          throw new TypeError( 'Array.prototype.reduce ' + 
            'called on null or undefined' );
        }
        if (typeof callback !== 'function') {
          throw new TypeError( callback +
            ' is not a function');
        }

        // 1. Let O be ? ToObject(this value).
        var o = new Object(this);

        // 2. Let len be ? ToLength(? Get(O, "length")).
        var len = o.length >>> 0; 

        // Steps 3, 4, 5, 6, 7      
        var k = 0; 
        var value;

        if (arguments.length >= 2) {
          value = arguments[1];
        } else {
          while (k < len && !(k in o)) {
            k++; 
          }

          // 3. If len is 0 and initialValue is not present,
          //    throw a TypeError exception.
          if (k >= len) {
            throw new TypeError( 'Reduce of empty array ' +
              'with no initial value' );
          }
          value = o[k++];
        }

        // 8. Repeat, while k < len
        while (k < len) {
          // a. Let Pk be ! ToString(k).
          // b. Let kPresent be ? HasProperty(O, Pk).
          // c. If kPresent is true, then
          //    i.  Let kValue be ? Get(O, Pk).
          //    ii. Let accumulator be ? Call(
          //          callbackfn, undefined,
          //          « accumulator, kValue, k, O »).
          if (k in o) {
            value = callback(value, o[k], k, o);
          }

          // d. Increase k by 1.      
          k++;
        }

        // 9. Return accumulator.
        return value;
      }
    });
  }


  // Production steps of ECMA-262,
  if (!Array.isArray) {
    Array.isArray = function(arg) {
      return Object.prototype.toString.call(arg) === '[object Array]';
    };
  }


  // Production steps of ECMA-262, Edition 5, 15.4.4.17
  // Reference: http://es5.github.io/#x15.4.4.17
  if (!Array.prototype.some) {
    Array.prototype.some = function(fun, thisArg) {
      'use strict';

      if (this == null) {
        throw new TypeError('Array.prototype.some called on null or undefined');
      }

      if (typeof fun !== 'function') {
        throw new TypeError();
      }

      var t = new Object(this);
      var len = t.length >>> 0;

      for (var i = 0; i < len; i++) {
        if (i in t && fun.call(thisArg, t[i], i, t)) {
          return true;
        }
      }

      return false;
    };
  }

  if (!Array.prototype.keys) {
     Array.prototype.keys = function() {
         var k, a = [], nextIndex = 0, ary = this;
         k = ary.length;
         while (k > 0) a[--k] = k;
         a.next = function(){
             return nextIndex < ary.length ?
                 {value: nextIndex++, done: false} :
                 {done: true};
         };
     return a;
     };
  }

  if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = (function (Obj, max, min) {
      'use strict';
      return function indexOf (member, fromIndex) {
        if (this === null || this === undefined) {
          throw TypeError('Array.prototype.indexOf called on null or undefined');
        }

        var that = new Obj(this);
        var len = that.length;
        var i = min(fromIndex || 0, len);

        if (i < 0) {
          i = max(0, len + i);
        } else if (i >= len) {
          return -1;
        }

        if (member === undefined) {
          for (; i !== len; ++i) {
            if (that[i] === undefined && i in that) {
              return i; // undefined
            }
          }
        } else if (member !== member) {
          for (; i !== len; ++i) {
            if (that[i] !== that[i]) {
              return i; // NaN
            }
          }
        } else {
          for (; i !== len; ++i) {
            if (that[i] === member) {
              return i; // all else
            }
          }
        }

        return -1; // if the value was not found, then return -1
      };
    }(Object, Math.max, Math.min));
  }


  // https://tc39.github.io/ecma262/#sec-array.prototype.includes
  if (!Array.prototype.includes) {
      Array.prototype.includes = (function (searchElement, fromIndex) {
          if (this == null) {
              throw new TypeError('"this" is null or not defined');
          }

          // 1. Let O be ? ToObject(this value).
          var o = new Object(this);

          // 2. Let len be ? ToLength(? Get(O, "length")).
          var len = o.length >>> 0;

          // 3. If len is 0, return false.
          if (len === 0) {
              return false;
          }

          // 4. Let n be ? ToInteger(fromIndex).
          //    (If fromIndex is undefined, this step produces the value 0.)
          var n = (fromIndex) ? fromIndex :0;

          // 5. If n ≥ 0, then
          //  a. Let k be n.
          // 6. Else n < 0,
          //  a. Let k be len + n.
          //  b. If k < 0, let k be 0.
          var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

          function sameValueZero(x, y) {
              return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
          }

          // 7. Repeat, while k < len
          while (k < len) {
              // a. Let elementK be the result of ? Get(O, ! ToString(k)).
              // b. If SameValueZero(searchElement, elementK) is true, return true.
              if (sameValueZero(o[k], searchElement)) {
                  return true;
              }
              // c. Increase k by 1.
              k++;
          }

          // 8. Return false
          return false;
      });
  }


  // Production steps of ECMA-262, Edition 6, 22.1.2.1
  if (!Array.from) {
      Array.from = (function() {
          var toStr = Object.prototype.toString;
          var isCallable = function(fn) {
              return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
          };
          var toInteger = function(value) {
              var number = Number(value);
              if (isNaN(number)) { return 0; }
              if (number === 0 || !isFinite(number)) { return number; }
              return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
          };
          var maxSafeInteger = Math.pow(2, 53) - 1;
          var toLength = function(value) {
              var len = toInteger(value);
              return Math.min(Math.max(len, 0), maxSafeInteger);
          };

          // The length property of the from method is 1.
          return function from(arrayLike /*, mapFn, thisArg */ ) {
              // 1. Let C be the this value.
              var C = this;

              // 2. Let items be ToObject(arrayLike).
              var items = arrayLike;

              // 3. ReturnIfAbrupt(items).
              if (arrayLike == null) {
                  throw new TypeError('Array.from requires an array-like object - not null or undefined');
              }

              // 4. If mapfn is undefined, then let mapping be false.
              var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
              var T;
              if (typeof mapFn !== 'undefined') {
                  // 5. else
                  // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
                  if (!isCallable(mapFn)) {
                      throw new TypeError('Array.from: when provided, the second argument must be a function');
                  }

                  // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
                  if (arguments.length > 2) {
                      T = arguments[2];
                  }
              }

              // 10. Let lenValue be Get(items, "length").
              // 11. Let len be ToLength(lenValue).
              var len = toLength(items.length);

              // 13. If IsConstructor(C) is true, then
              // 13. a. Let A be the result of calling the [[Construct]] internal method 
              // of C with an argument list containing the single item len.
              // 14. a. Else, Let A be ArrayCreate(len).
              var A = isCallable(C) ? new C(len) : new Array(len);

              // 16. Let k be 0.
              var k = 0;
              // 17. Repeat, while k < len… (also steps a - h)
              var kValue;
              while (k < len) {
                  kValue = items[k];
                  if (mapFn) {
                      A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
                  } else {
                      A[k] = kValue;
                  }
                  k += 1;
              }
              // 18. Let putStatus be Put(A, "length", len, true).
              A.length = len;
              // 20. Return A.
              return A;
          };
      }());
  }
    
  /************************* Date *************************/

  if (!Date.prototype.toISOString) {
    (function() {

      function pad(number) {
        if (number < 10) {
          return '0' + number;
        }
        return number;
      }

      Date.prototype.toISOString = function() {
        return this.getUTCFullYear() +
          '-' + pad(this.getUTCMonth() + 1) +
          '-' + pad(this.getUTCDate()) +
          'T' + pad(this.getUTCHours()) +
          ':' + pad(this.getUTCMinutes()) +
          ':' + pad(this.getUTCSeconds()) +
          '.' + (this.getUTCMilliseconds() / 1000).toFixed(3).slice(2, 5) +
          'Z';
      };

    })();
  }
  
    //  NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
    // 
    //  USE YOUR OWN COPY. IT IS EXTREMELY UNWISE TO LOAD CODE FROM SERVERS YOU DO
    //  NOT CONTROL.
    // 
    // Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
    // documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
    // the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
    // and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    // 
    // The above copyright notice and this permission notice shall be included in all copies or substantial portions 
    // of the Software.
    // 
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED 
    // TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL 
    // THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
    // CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
    // DEALINGS IN THE SOFTWARE.
 
    /**
     *
     * Log an error to a DataExtension
     *
     * Centralised version of error logging in SSJS script. Not recommended in batch Emails - use AMP error log 
     * for this purpose instead. On error, a record will be written to the error log DE.
     *
     * This function requires a DataExtension defined in settings.de.logError
     *
     * @param   {object}    o                       Holds the data for the error log.
     *
     * @param   {string}    o.method                The method calling the error.
     * @param   {string}    o.message               The error message for better understanding of the error.
     * @param   {string}    o.source                A detailed name of the error origin. E.g. [Email] Survey.
     * @param   {string}    [o.subscriberKey]       If given, the subscriberKey triggering the error
     * @param   {number}    [o.jobid]               The JobId if the error is caused from an email sent.
     * @param   {number}    [o.listid]              The ListId if the error is caused from an email sent.
     * @param   {number}    [o.batchid]             The BatchId if the error is caused from an email sent.
     * @param   {string}    [o.sourceType]          The SourceType. e.g. Email, Web, CRM.
     * @param   {boolean}   [o.raiseError]          Indicates whether an error should be raised to stop an email
     *                                              from sending out. Only works in Email Studio. A value of true skips the 
     *                                              send for current Subscriber and moves to next Subscriber
     *                                              A value of false stops the send and returns an error.
     *
     * @returns  {string}                           The eventId for the error.
     */
    function log(severity, message) {
        var name = [],
            value = [],
            row = {
                "ProcessName": ProcessName,
                "InstanceID": InstanceID,
                "SequenceID": SequenceID,
                "MemberID":mid,
                "Message": message,
                "Severity": severity
            };

        for( var i in row ) {
            name.push(i);
            value.push(row[i]);
        }

        var resp = Platform.Function.InsertDE("ENT.EventLog",name,value);

        if (debugMode) Write(Platform.Function.Stringify(row) + '<br><br>');
        SequenceID++;
    }

    /**
     * Check if value is an object.
     *
     * @param {*} value The value to check.
     *
     * @returns  {boolean}
     */
    function isObject(value) {
        if (value === null) { return false; }
        return ((typeof value === 'function') || (typeof value === 'object'));
    }

    /**
     * Add units to a datetime
     *
     * @param   {date}      dt              The original date
     * @param   {number}    number          Numbers to add to the dt
     * @param   {string}    [unit=Hours]    Units to add ['Seconds','Minutes','Hours','Days','Months','Years'].
     *
     * @returns  {date}  The new date
     */
    function dateAdd(dt, number, unit) {
        var u = (unit) ? unit : 'Hours',
            validUnits = ['Seconds','Minutes','Hours','Days','Months','Years'],
            date = new Date(dt);

        //if(!validUnits.includes(u)) {
        //    debug('(dateAdd)\n\tUnit not allowed: '+u+'. Use Hours instead' );
        //}

        // convert number to integer
        number = Number(number);

        switch(u) {
            case 'Seconds':
                date.setSeconds(date.getSeconds() + number);
            break;
            case 'Minutes':
                date.setMinutes(date.getMinutes() + number);
            break;
            case 'Days':
                date.setHours(date.getHours() + (number*24));
            break;
            case 'Months':
                date.setMonth(date.getMonth() + number);
            break;
            case 'Years':
                date.setFullYear(date.getFullYear() + number);
            break;
            default:
                date.setHours(date.getHours() + number);
        }
        return date;
    }

    /**
     * Subtract units to a datetime
     *
     * @param   {date}      dt              The original date
     * @param   {number}    number          Number to subtract from the dt
     * @param   {string}    [units=Hours]   Units to subtract ['Seconds','Minutes','Hours','Days','Months','Years'].
     *
     * @returns  {date}  The new date
     */
    function dateSubtract(dt, number, unit) {
        var u = (unit) ? unit : 'Hours',
            validUnits = ['Seconds','Minutes','Hours','Days','Months','Years'],
            date = new Date(dt);

        if(!validUnits.includes(u)) {
            debug('(dateSubtract)\n\tUnit not allowed: '+u+'. Use Hours instead' );
        }

        // convert number to integer
        number = Number(number);

        switch(u) {
            case 'Seconds':
                date.setSeconds(date.getSeconds() - number);
            break;
            case 'Minutes':
                date.setMinutes(date.getMinutes() - number);
            break;
            case 'Days':
                date.setHours(date.getHours() - (number*24));
            break;
            case 'Months':
                date.setMonth(date.getMonth() - number);
            break;
            case 'Years':
                date.setFullYear(date.getFullYear() - number);
            break;
            default:
                date.setHours(date.getHours() - number);
        }
        return date;
    }

    /**
     * Remove time from given DateTime
     *
     * @param   {date}  dt  The datetime
     *
     * @returns  {date}  Date
     */
    function getDateFromDateTime(dt) {
        var d = (dt.getMonth() + 1) + '/' + dt.getDate() + '/' + dt.getFullYear();
        return new Date(d);
    }

    /**
     * Get the current UTC Date
     *
     * @returns {date} UTC Date
     */
    function getDateUTC() {
        var utc = dateAdd(new Date(), 6, 'Hours'),
            pad = function(number) { return(number < 10) ? '0' + number : number; };

        return new Date( utc.getFullYear() +
          '-' + pad(utc.getMonth() + 1) +
          '-' + pad(utc.getDate()) +
          'T' + pad(utc.getHours()) +
          ':' + pad(utc.getMinutes()) +
          ':' + pad(utc.getSeconds()) +
          '.' + (utc.getMilliseconds() / 1000).toFixed(3).slice(2, 5) +
          'Z'
        );
    }
    
    /**
     * Get the current UnixTimestamp
     *
     * @returns {number} The current UnixTimestamp in UTC
     */
    function getUnixTimestamp() { 
        var now = new Date();
        return Math.floor(now.valueOf() / 1000); 
    }

    /**
     * Get the difference in hours between two datetimes
     *
     * @param   {date}  d1  Date 1
     * @param   {date}  d2  Date 2
     *
     * @returns  {number}  hours difference
     */
    function dateDiffInHours(d1, d2) { return (d1.valueOf() - d2.valueOf()) / 1000 / 60 / 60; }

    /**
     * Get the difference in days between two datetimes
     *
     * @param   {date}  d1  Date 1
     * @param   {date}  d2  Date 2
     *
     * @returns  {number}  days difference
     */
    function dateDiffInDays(d1, d2) {
        var dt1 = new Date(d1.getFullYear(), d1.getMonth(), d1.getDate());
        var dt2 = new Date(d2.getFullYear(), d2.getMonth(), d2.getDate());
        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var millisBetween = dt2.getTime() - dt1.getTime();
        var days = millisBetween / millisecondsPerDay;
        return Math.round(days);
    }

    /**
     * Convert minutes into a human readable form
     *
     * @param   {number}  m  Miniutes given
     *
     * @returns  {string}
     */
    function timeConvert(m) {
        var s = [];
        var r = {
                day: Math.round(m/24/60),
                hour: Math.floor(m/60%24),
                minute: Math.round(m%60)
            };

        for(var k in r) {
            if( r[k] > 0 ) {
                s.push((r[k] > 1) ? r[k]+' '+k+'s' : r[k]+' '+k);
            }
        }
        return s.join(' and ');
    }

    /**
     * Group an array of object by one property
     * 
     * @param {array} data  An array of objects
     * @param {string} key  The property or accessor
     *
     * @returns {array} the grouped array
     *
     * @see {@link https://stackoverflow.com/questions/14446511/most-efficient-method-to-groupby-on-an-array-of-objects|StackOverflow}
     * @see {@link https://gist.github.com/robmathers/1830ce09695f759bf2c4df15c29dd22d|RobMathers Git}
     * 
     */
    function groupBy(data, key) { // `data` is an array of objects, `key` is the key (or property accessor) to group by
        // reduce runs this anonymous function on each element of `data` (the `item` parameter,
        // returning the `storage` parameter at the end
        return data.reduce(function(storage, item) {
        // get the first instance of the key by which we're grouping
        var group = item[key];

        // set `storage` for this instance of group to the outer scope (if not empty) or initialize it
        storage[group] = storage[group] || [];

        // add this item to its group within `storage`
        storage[group].push(item);

        // return the updated storage to the reduce function, which will then loop through the next 
        return storage; 
        }, {}); // {} is the initial value of the storage
    }

    /**
     * Check if a string is in the object
     *
     * @param   {string}    needle      The string to find in the object.
     * @param   {object}    haystack    The object to search.
     *
     * @returns  {boolean}
     */
    function inObject(needle,haystack) {
       return Object.keys(haystack).some(function(k) {
            return obj[k] === needle; 
        });
    }

    /**
     * Check if a string is in the object) recursively.
     *
     * @param   {string}    needle      The string to find in the object.
     * @param   {object}    haystack    The object to search.
     *
     * @returns  {boolean}
     */
    function inObjectRecursive(needle,haystack) {
        var exists = false;
        var keys = Object.keys(haystack);
        
        for(var i = 0; i < keys.length; i++) {
            var key = keys[i];
            var type = typeof haystack[key];
            
            if(type === 'object') {
                exists = inObjectRecursive(needle, haystack[key]);

            } else if(type === 'array') {
                for(var j = 0; j < haystack[key].length; j++) {
                    exists = inObjectRecursive(needle, haystack[key][j]);
                    if(exists) {
                        break;
                    }
                }
            } else if(type === 'string') {
                exists = haystack[key] == needle;   
            }

            if(exists) {
                break;
            }
        }
        return exists;
    }

    /**
     * Shuffles an array.
     *
     * @param {array} a Array containing the items.
     *
     * @returns {array} The suffeled array
     */
    function shuffle(a) {
        var j, x, i;
        for (i = a.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = a[i];
            a[i] = a[j];
            a[j] = x;
        }
        return a;
    }

    /**
     * Delete item in array.
     *
     * @param {array}   array   Array containing the item.
     * @param {string}  item    The item to be deleted
     *
     * @returns {array} The new array
     */
    function deleteArrayItem(array, item) {
        for (var k = 0; k < array.length; k++) {
            if( array[k] == item ) {
                array.splice(k, 1);
            }
        }
        return array;
    }

    /**
     * Create AMP variables from an object
     *
     * @param  {object}  value  A name and value object.
     *
     * @example
     * // creates 3 AMP variables
     * createAmpVariables({
     *      email: 'info@email360.io',
     *      source: 'Email360',
     *      url: 'http://www.email360.io'
     * });
     */
    function createAmpVariables(value) {
        debug('(createAmpVariables) Create AMP Script Variable:');
        for (var i in value) {
            Variable.SetValue(i, value[i]);
            debug('\t@' + i + ' with value ' + value[i]);
        }
    }

    /**
     * Returns the current member id where this code is executed
     */
    function getMemberID() {
        return Platform.Function.AuthenticatedMemberID();
    }


    /**
     * SSJS wrorkaround to use console server side 
     */
    function console_log() {
        Platform.Response.Write('<scr' + 'ipt>');
        Platform.Response.Write('console.log.apply(null,' + Platform.Function.Stringify(Array.from(arguments)) + ')');
        Platform.Response.Write('</scr' + 'ipt>'); 
    }

    /**
     * Display the message appropriate to the Debugging Mode
     *
     * @param {string} message The message to be displayed. 
     */
    function debug(message) {

        // remove script tags from string
        var message = (typeof message === 'string') ? message.replace(/<script[\s\S]*?>/gi, '').replace(/<\/script>/gi, '') : message;

        if( Array.isArray(debugMode) ) {
            if(debugMode.includes('console')) {
                console_log(message);
            }
            if(debugMode.includes('html')) {
                var m = (typeof message == 'string') ? message.replace('\n', '<br/>').replace('\t', '&nbsp;&nbsp;&nbsp;&nbsp') : Platform.Function.Stringify(message);
                Platform.Response.Write('<pre style="margin:0.85em 0px;"><span style="font-size: 11px;">'+m+'</span></pre>');
            }
            if(debugMode.includes('text')) {
                Platform.Response.Write('{'+Platform.Function.Stringify(message)+'}\n');
            }
        }
    }

    /**
     * Wait for n Miliseconds
     *
     * @param  {number} ms Miliseconds to sleep
     */
    function wait(ms) {
        debug("(Wait)\n\tOK: "+ms+" Miliseconds");
        var s = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - s) > ms){
                break;
            }
        }   
    }

    /**
     * Validates if the contentBlock with the given key exists
     *
     * @param {string} customerKey  The ContentBlockKey
     *
     * @returns  {boolean}
     */
    function isContentBlockByKey(customerKey) {
        try {
            // Cannot use the 3rd parameter to continue on error. The 2nd parameter cannot be NULL and not every implemantion uses ImpressionRegions.
            var c = Platform.Function.ContentBlockByKey(customerKey);
            return true;
        } catch (e) {
            return false;
        }
    }    

    /**
     * Returns the current page URL optional with parameters
     *
     * @param   {boolean}    [withParam=false]  Keep parameters from the url
     *
     * @returns  {string}
     */
    function getPageUrl(withParam) {
        var p = (typeof withParam != 'boolean') ? true : withParam,
            url = Request.GetQueryStringParameter('PAGEURL');
        return (p) ? url : url.split('?')[0];
    }

    /**
     * Verify if the given string is a possible SFMC default CustomerKey
     *
     * @param {string} str The string to be tested
     *
     * @returns  {boolean}
     */
    function isCustomerKey(str) { return RegExp('^[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$').test(str); }

    /**
     * Perform an HTTP request allowing the usage of API methods.
     *
     * @param {string} method           The method to use e.g: POST, GET, PUT, PATCH, and DELETE
     * @param {string} url              The url to send the request to
     * @param {string} [contentType]    The contentType to use e.g: application/json
     * @param {object} [payload]        A payload for the request body
     * @param {object} [header]         Header values as key value pair
     *
     * @returns {object} Result of the request
     */
    function httpRequest(method,url,contentType,payload,header) {
        var req = new Script.Util.HttpRequest(url);
        req.emptyContentHandling = 0;
        req.retries = 2;
        req.continueOnError = true;
        req.method = method;
        for( var k in header ) {
            req.setHeader(k, header[k]);
        }
        if(typeof contentType !== 'undefined' && contentType !== null) { req.contentType = contentType; }
        if(typeof payload !== 'undefined' && payload !== null) { req.postData = Platform.Function.Stringify(payload); }

        try {
            debug('(httpRequest)\n\tCall method '+method+' on '+url); 
            var res = req.send();

            return {
                status: Platform.Function.ParseJSON(String(res.statusCode)),
                content: Platform.Function.ParseJSON(String(res.content))
            };

        } catch(e) {
            return {
                status: '500',
                content: e
            };
        }
    }

    /**
     * Generate a random string for the given fieldType
     *
     * Allowed types: Decimal,EmailAddress,Boolean,Number
     * Date, Phone, Locale, Text.
     *
     * @param {string} fieldType  Defines the data to be generated. 
     *
     * @returns {string} The generated data string
     */
    function getRandomData(fieldType) {
        var loc;
        if(fieldType == "Decimal")       return Math.floor(Math.random() * (1000 - 100) + 100) / 100;
        if(fieldType == "EmailAddress")  return Math.floor(Math.random() * 10000000000) + "@sample.com.invalid";
        if(fieldType == "Boolean")       return (Math.random() >= 0.5);
        if(fieldType == "Number")        return Math.floor(Math.random() * 100);
        if(fieldType == "Date")          return new Date(+(new Date()) - Math.floor(Math.random() * 10000000000));
        if(fieldType == "Phone") {
            var countryCode = ['','+x','+xx','+xxx','+1-xxx','+44-xxxx'],
                length = [9,10,11],
                numberCount = length[Math.floor(Math.random() * length.length)],
                prefix = countryCode[Math.floor(Math.random() * countryCode.length)];
            if(/x/g.test(prefix)) {
                var l = ((prefix.match(/x/g) || []).length);
                // iterate to generate a random number each occurrence time.
                for (var x = 0; x < l; x++) {
                    prefix = prefix.replace('x', (Math.floor(Math.random() * 8)+1));
                }
                prefix += ' ';
            }
            var n = prefix;
            for (var i = 0; i < numberCount; i++) {
                n += Math.floor(Math.random() * 9);
            }
            return n;
        }
        if(fieldType == "Locale") {
            // Maximum character length per liner in email studio is around 768 characters.
            var l1 = ['af-za','am-et','ar-ae','ar-bh','ar-dz','ar-eg','ar-iq','ar-jo','ar-kw','ar-lb','ar-ly','ar-ma','ar-om','ar-qa','ar-sa','ar-sy','ar-tn','ar-ye','as-in','ba-ru','be-by','bg-bg','bn-bd','bn-in','bo-cn','br-fr','ca-es','co-fr','cs-cz','cy-gb','da-dk','de-at','de-ch','de-de','de-li','de-lu','dv-mv','el-gr','en-au','en-bz','ca','en-gb','en-ie','en-in','en-jm','en-my','en-nz','en-ph','en-sg','en-tt','en-us','en-za','en-zw','es-ar','es-bo','es-cl','es-co','es-cr','es-do','es-ec','es-es','es-gt','es-hn','es-mx','es-ni','es-pa','es-pe','es-pr','es-py','es-sv','es-us','es-uy','es-ve','et-ee','eu-es','fa-ir','fi-fi','fo-fo','fr-be','fr-ca','fr-ch','fr-fr','fr-lu','fr-mc','fy-nl','ga-ie','gd-gb','gl-es','gu-in','he-il','hi-in','hr-ba','hr-hr','hu-hu','hy-am'];
            var l2 = ['id-id','ig-ng','ii-cn','is-is','it-ch','it-it','ja-jp','ka-ge','kk-kz','kl-gl','km-kh','kn-in','ko-kr','ky-kg','lb-lu','lo-la','lt-lt','lv-lv','mi-nz','mk-mk','ml-in','mn-mn','mr-in','ms-bn','ms-my','mt-mt','nb-no','ne-np','nl-be','nl-nl','nn-no','oc-fr','or-in','pa-in','pl-pl','ps-af','pt-br','pt-pt','rm-ch','ro-ro','ru-ru','rw-rw','sa-in','se-fi','se-no','se-se','si-lk','sk-sk','sl-si','sq-al','sv-fi','sv-se','sw-ke','ta-in','te-in','th-th','tk-tm','tn-za','tr-tr','tt-ru','ug-cn','uk-ua','ur-pk','vi-vn','wo-sn','xh-za','yo-ng','zh-cn','zh-hk','zh-mo','zh-sg','zh-tw','zu-za'];
            var locales = l1.concat(l2);
            return locales[Math.floor(Math.random() * locales.length)].toUpperCase();
        }
        if(fieldType ==  "Text") {
            var str = "lorem ipsum dolor sit amet consectetur adipiscing elit donec vel nunc eget augue dignissim bibendum";
            arr = str.split(" ");
            var ctr = arr.length, temp, index;
            while (ctr > 0) {
                index = Math.floor(Math.random() * ctr);
                ctr--;
                temp = arr[ctr];
                arr[ctr] = arr[index];
                arr[index] = temp;
            }
            str = arr.join(" ");
            return str;
        }
    }

    /**
     * Generate amp script variables from a SSJS Object
     *
     * The SSJS object will be flatten. Object keys will retain
     * the key as name while array items will add the key position.
     *
     * Example: { "Hello": "World", "MyArray": ["one","two"], "MyNestedObject": {"name": "John"} }
     * Output: @Hello = "World"
     *         @MyArray_0 = "one"
     *         @MyArray_1 = "two"
     *         @MyNestedObject_name = "John"
     *
     * @param {object} ssjsObject       The object to be converted
     * @param {string} [prefix=null]    An optional prefix for each ampScirpt variable
     * @param {string} [delimiter=-]     THe delimiter between each nested item
     *
     * @returns {string} The generated data string
     */
    function createAmpVariablesFromObject(ssjsObject,prefix,delimiter) {
        var p = (prefix)?prefix:'',
            d = (delimiter)?delimiter:'_',
            ampObject = {};

        flatten(ssjsObject, '');

        createAmpVariables(ampObject);
        return ampObject;

        function flatten(currentObject, previousKeyName) {

            if( Array.isArray(currentObject) ) {
                for (var i = 0; i < currentObject.length; i++) {
                    flatten(currentObject[i], (previousKeyName == null || previousKeyName == '') ? i : previousKeyName + d + i );
                }

            } else {

                for (var key in currentObject) {
                    var value = currentObject[key];

                    if (!isObject(value)) {
                        if (previousKeyName == null || previousKeyName == '') {
                            ampObject[p+key] = value;
                        } else {
                            if (key == null || key == '') {
                                ampObject[p+previousKeyName] = value;
                            } else {
                                ampObject[p+previousKeyName + d + key] = value;
                            }
                        }
                    } else {
                        flatten(value, (previousKeyName == null || previousKeyName == '') ? key : previousKeyName + d + key);
                    }
                }
            }
        }
    }


    /**
     * Load a content file from any github repo
     *
     * This can be used to speed up development of cloudpages while keep the benefit of github
     *
     * @param {object} obj              The object holding the required parameters
     *
     * @param {string} obj.username     The github username
     * @param {string} obj.repoName     The name of the repository
     * @param {string} obj.filePath     The full file path including the filename inside the repo
     * @param {string} obj.token        The access token generated for the repo inside github
     *
     * @returns {string} The entire content of the github content
     *
     * @example
     * // set github parameter
     * var obj = {
     *     username : "email360-github",
     *     token    : "De0ed0b390deabBfGc30761bD535c036fbc7eAe5",
     *     repoName : "email360",
     *     fileName : "sample.js"
     *  };
     *
     * // pull the content from github
     * var githubContent = getGitHubRepoContent(obj);
     *
     * // convert the content into an AMPScript variable
     * Platform.Variable.SetValue("@githubContent", githubContent);
     * 
     * // execute the content
     * %%=TreatAsContent(@githubContent)=%%
     */
    function getGitHubRepoContent(obj){
        var resource = 'https://api.github.com/repos/'+ obj.username + '/' + obj.repoName + '/contents/' + obj.filePath;
        debug('(getGitHubRepoContent)\n\tOK: Call Github for the following resource: '+resource);
        var req = new Script.Util.HttpRequest(resource);
            req.emptyContentHandling = 0;
            req.retries = 2;
            req.continueOnError = true;
            req.setHeader("Authorization","Bearer " + obj.token);
            req.setHeader("User-Agent", obj.username + '/' + obj.repoName);
            //  This header is very important! It allows to get the file content raw version.
            req.setHeader("Accept", "application/vnd.github.v3.raw");
            req.setHeader("Cache-Control", "no-cache");
            req.method = "GET";

        var resp = req.send();

        return resp.content;
    }


    // undocumented on purpose. Used to update the settings object with a custom setting object
    function _updateSettings(setting) {
        orgSetting = new settings();

        for(var k in setting) {
            orgSetting[k] = setting[k];
        }
        return orgSetting;
    }



</script>