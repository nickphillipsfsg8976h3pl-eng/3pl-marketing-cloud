<script runat="server">
    Platform.Load("core", "1");

    try {

        // get params
        var campaign_id = Request.GetQueryStringParameter("campaign_id");


        // find table
        var table = DataExtension.Init("Campaign_Salesforce");


        // run query
        var data = table.Rows.Lookup(["Id"], [campaign_id], 99999999, "Name DESC");


        // sanitize data
        for (var i = 0; i < data.length; i++) {
            delete data[i]._CustomObjectKey;
            delete data[i]._CreatedDate;
        } //for


        // set headers
        Platform.Response.SetResponseHeader("Content-Type", "application/json");


        // return results
        Write(Stringify(data));


    } catch (error) {

        Write(Stringify({
            error: error
        }));

    }
</script>