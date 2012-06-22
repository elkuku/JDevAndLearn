var DalService =
{
    ajaxUri:'index.php?option=com_devandlearn&tmpl=component&format=raw',

    check : function(url, el)
    {
        //var resultDiv = el.parentNode.nextSibling.nextSibling;

        new Request.JSON(
            {
                url:this.ajaxUri
                    +'&task=service.check'
                    +'&url='+url,

                onComplete:function(r)
                {
                    //resultDiv.set('html', r.text);
                }
            }).send();

    }
};
