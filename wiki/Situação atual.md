![Overview geral](http://doc.php.net/images/revcheck/info_revcheck_php_all_lang.png)

***
O gráfico acima representa a situação que desejamos mudar! O PHP apresenta uma quantidade pequena de arquivos atualizados quando comparados a outras versões da documentação
***
![Status Atual](http://doc.php.net/images/revcheck/info_revcheck_php_pt_BR.png)

***
Os arquivos estão subdivido em quatro categorias problema, são elas:

### Up to date files
Como dá pra se inferir pelo nome, são os arquivos atualizados com a árvore en. Os arquivos que entram para esse grupo são aqueles que possuam na tag de acompanhamento, a mesma revisão que a versão en.

### Outdated Files - [Lista de arquivos](http://doc.php.net/revcheck.php?p=files&lang=pt_BR)
Os arquivos marcados como desatualizados são aqueles que possui o número de revisão, na tag de acompanhamento inferior à língua inglesa.

### Files without revision number - [Lista de arquivos](http://doc.php.net/revcheck.php?p=misstags&lang=pt_BR)
Os arquivos nesta categoria não possuem tag de revisão para fazer o acompanhamento, sendo assim, não existe a possibilidade de acompanhar se os arquivos estão, ou não, atualizados.
Este problema foi introduzido na migração, em 2009, do CSV para SVN.

### Files available for translation - [Lista de arquivos](http://doc.php.net/revcheck.php?p=missfiles&lang=pt_BR)
Arquivos disponíveis para tradução. Estes jamais foram traduzidos e representam grande parcela dos arquivos que precisam de atenção.

### Revcheck local

Para obter uma lista atualizada dessas estatísticas, a partir do seu checkout local, execute:

```
php -d error_reporting=0 doc-base/scripts/revcheck.php pt_BR > revcheck.html ;
# xdg-open revcheck.html # no linux
# open revcheck.html # no OS X
# iexplore revcheck.html # no WINDOWS
```

Isso irá criar um arquivo local chamado `revcheck.html` com as mesmas estatísticas, além de um sumário das reservas de arquivos conforme descrito no arquivo `translation.xml`.
