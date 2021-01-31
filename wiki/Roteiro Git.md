## Introdução

Este roteiro é destinado àqueles que querem contribuir com o manual do PHP utilizando o ambiente Git. É especificamente destinado que preferem esse ambiente em particular, mas também àqueles que ainda não possuem credenciais PHP.net, mas que pretendem se tornar tradutores permanentes do manual.

Esse mesmo roteiro existe para quem prefere usar [SVN em linha de comando](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-SVN). Para contribuições esporádicas ou sem instalação de ferramentas, veja o roteiro de como realizar contribuições pelo [Editor Online](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-Editor-Online) ou pelo [GitHub](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-GitHub).

## Roteiro do Git

Para contribuir com o manual são quatro passos, assim resumidos:

1. Baixar ou atualizar os arquivos fontes;
2. Traduzir ou sincronizar uma tradução;
3. Validar a consistência do manual;
4. *Commit* e *pull request*.

Embora seja possível utilizar ambientes Windows (e outros) para traduzir o manual, o ambiente explicado aqui é um Linux (especificamente Debian/Ubuntu), dada a facilidade de instalação (ou virtualização) dessa distribuição em particular.

### Passo Zero: *Fork* e obtendo os fontes

Os fontes oficiais são gerenciados num repositório SVN, e uma ponte SVN/GitHub foi criada para permitir o uso do `git` e das funcionalidades comunitárias do GitHub. Para utilizar essa ponte é preciso ir até [esse repositório](https://github.com/phpdocbrbridge/traducao) e realizar um fork para a sua conta no GitHub.

É necessário também ambos os clientes SVN e git no computador. Num terminal, verifique se possui os clientes instalados:

```
svn --version | head -n 1
git --version
```

Caso não possua algum instalado, execute:

```
sudo apt-get install git          # para instalar o git
sudo apt-get install subversion   # para instalar o svn
```

Depois é preciso baixar os fontes uma única vez. Para tanto, execute:

```
mkdir phpdoc
cd phpdoc
git init
git remote add -f origin https://github.com/SEULOGINGITHUBAQUI/traducao.git
git remote add  upstream https://github.com/phpdocbrbridge/traducao
git pull origin master
git fetch upstream
git checkout master
git merge upstream/master -m "Upstream merge."
svn checkout https://svn.php.net/repository/phpdoc/doc-base/trunk doc-base
svn checkout https://svn.php.net/repository/phpdoc/en/trunk en
```

Isso irá criar uma pasta phpdoc no mesmo diretório que o comando for executado. Toda a tradução acontecerá aqui. Para entrar na pasta e ver o seu conteúdo:

```
ls
```

Haverá três diretórios aqui:

* **doc-base**: Contém scritps e outros arquivos necessários a compilação do manual (SVN).
* **en**: Contém os originais do manual, em inglês (SVN).
* **pt_BR**: Contém as traduções do manual, especificamente a tradução para português do Brasil (`git`).

Você somente vai mexer com arquivos dentro de `pt_BR`. As outras partes, sob controle do SVN, o Git irá ignorar (ver `.gitignore`).

Para ver se tudo deu certo, faça um `git status`, qual deve retornar algo como:

```
No ramo master
nada a submeter, diretório de trabalho vazio
```

Esse passo só será feito uma única vez. O precedimento normal é uma repetição dos passos seguintes.

### Passo 1: Atualizando os fontes

Para trabalhar a partir dos fontes mais atuais possíveis, sempre comece com um:

```
svn update doc-base
svn update en
git fetch upstream
git checkout master
git merge upstream/master -m "Upstream merge."
```

Isso vai atualizar os dois diretórios SVN e baixar no seu fork quaisquer alterações realizadas no repositório ponte da tradução. Após atualizar é interessante antes de começar a trabalhar numa tradução de também executar:

```
php doc-base/configure.php --enable-xml-details --with-lang=pt_BR
```

Esse script verifica a integridade do XML. Está tudo bem se no final aparecer um gatinho em ASCII art. Se acabar em erro o jeito é trabalhar no erro primeiro, já que começar com o manual inconsistente impede de realizar o passo 3.

Para facilitar, você pode criar um script bash que realize esses passos numa tacada só.

```
echo svn update doc-base >> sync.sh
echo svn update en >> sync.sh
echo git fetch upstream >> sync.sh
echo git checkout master >> sync.sh
echo git merge upstream/master -m "Upstream merge." >> sync.sh
echo php doc-base/configure.php --enable-xml-details --with-lang=pt_BR >> sync.sh
chmod +x sync.sh
ls
```

Para executar, basta chamar um `./sync.sh` ou source `sync.sh`.

E aqui surge a primeira regra geral: **Antes de começar, atualize e valide.**

### Passo 2: Traduzir ou atualizar um arquivo

O manual do PHP é um documento enorme, e trabalho não falta. Você pode escolher que tipo de contribuição realizar. Em ordem de prioridade:

1. [Arquivos desatualizados](http://doc.php.net/revcheck.php?p=files&lang=pt_BR): Arquivos anteriormente traduzidos mas que foram posteriormente tiveram os originais atualizados.

2. [Arquivos sem tags](http://doc.php.net/revcheck.php?p=misstags&lang=pt_BR): Arquivos traduzidos mas que a ausência de tags de tradução (ver abaixo) impedem acompanhar a sincronia.

3. [Not in EN tree](http://doc.php.net/revcheck.php?p=oldfiles&lang=pt_BR): Arquivos que existem na tradução mas não original. Provavelmente movidos, ou mesmo a apagar.

4. [Arquivos não traduzidos](http://doc.php.net/revcheck.php?p=missfiles&lang=pt_BR): Aparecem no manual totalmente em inglês.

O processo de tradução em si é bem simples. Original e tradução tem sempre os mesmos caminhos relativos, mudando apenas a pasta inicial, `en` ou `pt_BR`. No caso da tradução de arquivo inexistente na pasta `pt_BR` basta criá-lo, simplesmente. Depois é abrir ambos os arquivos, original e tradução, e traduzir a parte texto, preservando tags e comentários no final do arquivo.

**Dica 1:** Veja como [configurar um editor de texto simples](https://github.com/phpdocbrbridge/traducao/wiki/Configurando-seu-editor), que permita abrir os arquivos lado a lado ou que permitam alternar abas rapidamente via teclado. Abrir arquivos lado a lado ajuda na hora de novas traduções, e o rápido alternar abas permite descobrir alterações estruturais "no olho".

**Dica 2:** Tente preservar a [quantidade linhas igual entre os arquivos](https://github.com/phpdocbrbridge/traducao/wiki/Guia-de-edi%C3%A7%C3%A3o-do-manual#comprimentos-de-linha), além de manter as tags estruturais [nas mesmas linhas entre original e tradução](https://github.com/phpdocbrbridge/traducao/wiki/Guia-de-edi%C3%A7%C3%A3o-do-manual#comprimentos-de-linha). Isso fará muita diferença for fazer atualização de traduções. É muito mais fácil detectar o que é preciso atualizar quando essa “compatibilidade estrutural” é preservada.

**Sempre** que terminar uma tradução ou atualização, não se esqueça de **sincronizar a tag de revisão**, conforme explicado a seguir:

Em resumo, a segunda linha do arquivo deve estar no formato:

```
<!-- EN-Revision: nnnnnn Maintainer: xxxx Status: ssss --><!-- CREDITS: yyyy,zzzz -->
```

Onde:

* `nnnnnn`: É o número que aparece no original, no arquivo em inglês.
* `xxxx`: É o login do tradutor do manual, uma credencial PHP.net. Caso não possua preecher com `none`.
* `ssss`: É um código de status, conforme abaixo.
* `yyyy,zzzz`: Uma relação de logins dos tradutores com credencial PHP.net. Logins separados por vírgula.

Os valores previstos para o Status são:

* `ready`: Significa que a tradução está pronta.
* `revision`: Significa que a tradução está pronta, mas que o tradutor solicita que outra pessoa revise.
* `wip`: Sigla de *work in progress*, uma tradução que está no meio do caminho. Entre em contato *maintainer* do arquivo ou discuta a situação na lista, caso encontre um arquivo ainda `wip` depois de muito tempo.

Basicamente o que você faz é sincronizar o número da tradução a partir do número no arquivo original e inserir sua credencial na lista CREDITS, se tiver um credencial PHP.net. Se quiser pegar a manutenção do arquivo para si (e se possuir uma credencial PHP.net), você pode substituir o `xxxx` por seu login. Caso não possua uma credencial PHP.net, os créditos são dados na mensagem de commit.

**Observação:** Os scripts de monitoração das traduções utilizam REGEXs bem simples para ler a tag de revisão, então os espaços, ordem e formato geral das tags precisam ser exatamente como nos exemplos acima. De outra forma o script não rastreará corretamente as traduções.

### Passo 3: Validar a consistência do manual

Antes fazer um `push` no seu repositório ou enviar um *pull request* ao repositório ponte é estritamente necessário validar se a alteração não quebra a compilação do manual. Isso é feito através do comando:

```
php doc-base/configure.php --enable-xml-details --with-lang=pt_BR
```

Caso tenha definido o `sync.sh` acima, basta executá-lo. E daí vem a segunda regra geral: **Antes de gerar o patch atualize e valide.**

Ou o que é mais fácil de lembrar: **Antes de começar e assim que acabar `./sync.sh`**

**Observação 1:** O `sync.sh` atualiza o manual antes de compilar. Isso pode ser bom por um lado (melhora a certeza que o manual compilará *depois* que enviar o patch), mas pode ter o efeito colateral de quebrar a *sua compilação local* por causa de alguma *alteração de terceiros*. Isso dificulta o problema de separar se a quebra é por conta de alguma alteração sua ou de algo que foi trazido na atualização. Mas não tem muita escapatória. Ninguém vai aplicar um patch com o manual quebrado, menos vai aplicar um patch que aparentemente quebre a compilação do manual, então melhor correr atrás e ter o manual sempre validando.

**Observação 2:** Na verdade existe uma maneira de [visualizar suas alterações localmente](http://doc.php.net/tutorial/local-setup.php), sem esperar a publicação no site oficial. Mas isso também exige a instalação de um *toolchain* bem mais complicado. É bem possível conviver só validando o manual localmente, e revisar o resultado visual direto no servidor [http://docs.php.net/manual/pt_BR/](http://docs.php.net/manual/pt_BR/), um mirror que é atualizado a cada seis horas. Caso a alteração não apareça aqui depois desse tempo, pode ter ocorrido algum problema na compilação automática do manual, e os [logs](http://doc.php.net/logs/) devem ser verificados.

### Passo 4: `add/commit/push` e pull request

Após realizar as alterações desejadas, execute um:

```
git status
```

para verificar a lista de arquivos modificados, ver se não teve alguma coisa inesperadamente alterada.

Se houver arquivos novos, será preciso realizar um

```
git add caminho/nome_do_arquivo.xml
```
Para fechar um pacote de alterações no seu repositório local, rode um

```
git commit -m "MESSAGE"
```

sendo `MESSAGE` um resumo das suas alterações, em inglês. Pode ser um simples `Update translation.`.

É preciso ainda enviar as alterações ao seu repositório GitHub. Para tanto execute um:

```
git push origin master
```

Por fim, criar o pedido de [pull request](https://help.github.com/articles/using-pull-requests) através do GitHub.

Parece um pouco trabalhoso, mas nas verdade rapidamente se acostuma com esse processo. E é isso. GOTO STEP 1.
