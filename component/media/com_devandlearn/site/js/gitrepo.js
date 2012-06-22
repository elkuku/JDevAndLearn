var DalGitRepo =
{
    ajaxUri:'index.php?option=com_devandlearn&tmpl=component&format=raw',

    getInfo : function(type, dir)
    {
        var resultDiv = document.id('repo_'+dir);

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
