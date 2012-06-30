var DalGitRepo =
{
    ajaxUri:'index.php?option=com_devandlearn&tmpl=component&format=raw',

    getInfo : function(type, dir, btn)
    {
        var resultDiv = document.id('repo_'+dir);

        if(btn.hasClass('active'))
        {
            btn.removeClass('active');

            resultDiv.set('html', '');

            return;
        }
        else
        {
            console.log($$('#btns-' + dir));
            document.id('btns-' + dir).getElements('a').each(function(e){e.removeClass('active')});

            btn.addClass('active');
        }

        new Request.JSON(
        {
            url:this.ajaxUri
                +'&task=repo.getInfo'
                +'&type='+type
                +'&repo='+dir,

            onRequest:function()
            {
                resultDiv.set('html', 'Loading...');//@jgettext
                resultDiv.addClass('ajaxload5');
            },

            onComplete:function(r)
            {
                resultDiv.set('html', r.text);
                resultDiv.removeClass('ajaxload5');
            }
        }).send();
    }
};
