## Introdução

Este roteiro é destinado àqueles que querem contribuir com o manual do PHP utilizando o cliente SVN diretamente. É especificamente destinado àqueles que possuem credenciais no PHP.net para traduzir o manual, ou àqueles que ainda não possuem credenciais, mas que pretendem se tornar tradutores permanentes do manual, que por sua vez utiliza essa ferramenta específica.

Esse mesmo roteiro existe para quem prefere usar [git em linha de comando](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-Git). Para contribuições esporádicas ou sem instalação de ferramentas, veja o roteiro de como realizar contribuições pelo [Editor Online](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-Editor-Online) ou pelo [GitHub](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-GitHub).

## Roteiro do SVN

Para contribuir com o manual são quatro passos, assim resumidos:

1. Baixar ou atualizar os arquivos fontes.
2. Traduzir ou sincronizar uma tradução.
3. Validar a consistência do manual.
4. Gerar um patch e o submeter.

Embora seja possível utilizar ambientes Windows (e outros) para traduzir o manual, o ambiente explicado aqui é um Linux (especificamente Debian/Ubuntu) dada a facilidade de instalação (ou virtualização) dessa distribuição em particular.

### Passo Zero: SVN e obtendo os fontes pela primeira vez

Os fontes são gerenciados num repositório SVN. Então para trabalhar na tradução é necessário instalar um cliente SVN para o seu sistema operacional.

Num terminal, verifique se possui o cliente SVN instalado:

```
svn --version | head -n 1
```

Caso não possua instalado, execute:

```
sudo apt-get install subversion
```

É preciso baixar os fontes uma única vez. Para tanto, execute:

```
svn co https://svn.php.net/repository/phpdoc/modules/doc-pt_BR phpdoc
```

Isso irá criar uma pasta phpdoc no mesmo diretório que o comando for executado. Toda a tradução acontecerá aqui. Para entrar na pasta e ver o seu conteúdo:

```
cd phpdoc
ls
```

* `doc-base`: Contém scritps e outros arquivos necessários a compilação do manual.
* `en`: Contém os originais do manual, em inglês.
* `pt_BR`: Contém as traduções do manual, especificamente a tradução para português do Brasil.

Você somente vai mexer com arquivos dentro de `pt_BR`. As demais pastas nunca serão parte da geração de patchs, justamente para evitar subir qualquer coisa que tenha mexido nelas.

### Passo 1: Atualizando os fontes

Para trabalhar a partir dos fontes mais atuais possíveis, sempre comece com um:

```
svn update
```

Isso vai atualizar os três diretórios. Além disso é interessante antes de começar a trabalhar numa tradução de também executar:

```
php doc-base/configure.php --enable-xml-details --with-lang=pt_BR
```

Esse script verifica a integridade do XML. Está tudo bem se no final aparecer um gatinho em ASCII art. Se acabar em erro o jeito é trabalhar no erro primeiro, já que começar com o manual inconsistente impede de realizar o passo 3.

Para facilitar, você pode criar um script bash que realize esses passos numa tacada só.

```
echo svn update >> sync.sh
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

Antes de encaminhar patchs é estritamente necessário validar se a alteração não quebra a compilação do manual. Isso é feito através do comando

```
php doc-base/configure.php --enable-xml-details --with-lang=pt_BR
```

Caso tenha definido o `sync.sh` acima, basta executá-lo. E daí vem a segunda regra geral: **Antes de gerar o patch atualize e valide.**

Ou o que é mais fácil de lembrar: **Antes de começar e assim que acabar `./sync.sh`**

**Observação 1:** O `sync.sh` atualiza o manual antes de compilar. Isso pode ser bom por um lado (melhora a certeza que o manual compilará *depois* que enviar o patch), mas pode ter o efeito colateral de quebrar a *sua compilação local* por causa de alguma *alteração de terceiros*. Isso dificulta o problema de separar se a quebra é por conta de alguma alteração sua ou de algo que foi trazido na atualização. Mas não tem muita escapatória. Ninguém vai aplicar um patch com o manual quebrado, menos vai aplicar um patch que aparentemente quebre a compilação do manual, então melhor correr atrás e ter o manual sempre validando.

**Observação 2:** Na verdade existe uma maneira de [visualizar suas alterações localmente](http://doc.php.net/tutorial/local-setup.php), sem esperar a publicação no site oficial. Mas isso também exige a instalação de um *toolchain* bem mais complicado. É bem possível conviver só validando o manual localmente, e revisar o resultado visual direto no servidor [http://docs.php.net/manual/pt_BR/](http://docs.php.net/manual/pt_BR/), um mirror que é atualizado a cada seis horas. Caso a alteração não apareça aqui depois desse tempo, pode ter ocorrido algum problema na compilação automática do manual, e os [logs](http://doc.php.net/logs/) devem ser verificados.

### Passo 4: Gerar um patch e o submeter

A geração de patchs utiliza do próprio cliente do SVN. Porém como os patchs contém caminhos relativos então alguma uniformização *de onde os patchs são gerados* é necessário para organizar o processo. A padronização também evita que diretórios que não devem ser alterados estejam incluídos na geração.

Para gerar um patch, você deve estar na pasta `phpdoc/pt_BR`. Você pode confirmar isso rodando o comando `pwd`. Isso vai retornar o caminho atual do seu terminal. Esse caminho tem de terminar exatamente com `/phpdoc/pt_BR`. Não deve ser um diretório interno de `pt_BR` para não dificultar a vida de quem aplica os patchs, e nem pode ser no nível phpdoc ou superior para evitar subir algo dos originais ou ainda do maquinário do manual.

Estando no diretório correto, execute:

```
svn diff > minha_traducao.patch
```

Isso criará um arquivo com o nome minha_traducao.patch. Pode ser criativo com o nome do arquivo, mas evite espaços. Encaminhe esse arquivo para a [lista de email](mailto:doc-pt-br@lists.php.net). Antes de mandar qualquer email é necessário se inscrever na lista, mandando um email em branco para [doc-pt-br-subscribe@lists.php.net](mailto:doc-pt-br-subscribe@lists.php.net). Depois acompanhe pela própria lista a aplicação do patch, e posteriormente a publicação de sua contribuição no site oficial.

Esse é o último passo para quem não tem credencial no PHP.net. Quanto mais patchs aprovados você tiver mais fácil será de obter, depois, uma credencial PHP.net de forma que você mesmo possa enviar as alterações diretamente.

E é isso. GOTO STEP 1.
