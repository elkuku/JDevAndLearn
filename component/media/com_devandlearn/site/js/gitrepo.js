var DalGitRepo =
{
    ajaxUri:'index.php?option=com_devandlearn&tmpl=component&format=raw',

    getInfo : function(type, dir, el)
    {
        var resultDiv = el.parentNode.nextSibling.nextSibling;

        new Request.JSON(
        {
            url:this.ajaxUri
                +'&task=repo.getInfo'
                +'&type='+type
                +'&repo='+dir,

            onComplete:function(r)
            {
                resultDiv.set('html', r.text);
            }
        }).send();
    }
};
