Para iniciar com sua contribuição ao manual utilizando o Github, é necessário alguns passos. Veja abaixo como fazê-lo:

#### Efetuar seu cadastro no Github
![Cadastro Github](http://i.imgur.com/6hRmUv2.png)

Para tal, entre na [página de cadastro](github.com/join) do Github e faça o seu. É de graça! :+1:

#### Fork no projeto de tradução
![Imgur](http://i.imgur.com/ATGSSSF.png)

#### É hora de começar a editar
![Imgur](http://i.imgur.com/jHx1nxP.png)

#### Arquivos não traduzidos

No GitHub só existem os arquivos já traduzidos, de forma que é preciso um procedimento especial para incluir novas traduções dos [arquivos que só existem em Inglês](http://doc.php.net/revcheck.php?p=missfiles&lang=pt_BR).

Caso esteja num ambiente com suporte à SVN em linha de comando, basta rodar um `svn checkout https://svn.php.net/repository/phpdoc/en/trunk originais`. Isto criará uma pasta chamada `originais`, com todos os arquivos da tradução.

Para não ter que lidar com o SVN em linha de comando, existem alguns [clientes com interface gráfica](https://en.wikipedia.org/wiki/Comparison_of_Subversion_clients). É preciso instalá-los e fazer o equivalente do comando `checkout`. As vezes isso é traduzido como ["Obter uma cópia de trabalho"](https://tortoisesvn.net/docs/nightly/TortoiseSVN_pt_BR/tsvn-dug-checkout.html). O resultado é o mesmo: você obtêm uma cópia dos originais, e a partir da lista de arquivos inexistentes, pega um para traduzir, e depois adicionar com o mesmo nome e na mesma pasta relativa no repositório do GitHub.

#### Tudo certo! Vou enviar minhas modificações

#### Rebase

DEPOIS puxar detalhes daqui https://wiki.php.net/doc/translations/pt_br_github, e apagar este último.
