
  Platform.Load("Core", "1")

  
  //Get SubscriberKey
  var SUBSCRIBER_KEY = "stephan.peniguel@3plearning.com";
  

  //Initiate Dataviews
  var _Subscribers  = DataExtension.Init("ent._Subscribers");
  var _EnterpriseAttribute = DataExtension.Init("ent._EnterpriseAttribute");

  
  //Get Subscriber associated with SubscriberKey
  var subscriber = _Subscribers.Rows.Lookup(["SubscriberKey"], [SUBSCRIBER_KEY]);
  var subscriberID = subscriber[0].SubscriberID;
  var Status = subscriber[0].Status;
  

  //Get Profile Attributes associated with SubscriberID
  var attributes = _EnterpriseAttribute.Rows.Lookup(["_SubscriberID"], [subscriberID]);
  var GUID = attributes[0].GUID
  

  //Get All Attributes associated with GUID
  var allAttributes = _EnterpriseAttribute.Rows.Lookup(["GUID"], [GUID]);
  

  // Get All Subscribers associated with All Attributes SubscriberIDs
  var allSubscriberKeys = [];
  for (var i=0; i<allAttributes.length; i++) {
    var eachSubscriberID = allAttributes[i]._SubscriberID;
    var eachSubscriber = _Subscribers.Rows.Lookup(["SubscriberID"], [eachSubscriberID]);
    var eachSubscriberKey = eachSubscriber[0].SubscriberKey;
    allSubscriberKeys.push(eachSubscriberKey);
  }//for

  
  Write("All Subscriber Keys: "+ Stringify(allSubscriberKeys));
  
