<script runat="server">
    Platform.Load("core", "1");

    try {

        // get params
        var job_title = Request.GetQueryStringParameter("job_title");


        // find table
        var table = DataExtension.Init("JobTitle_Mapping_JobFunction");


        // run query
        var data = table.Rows.Lookup(["Job Title"], [job_title], 99999999, "_CustomObjectKey DESC");


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