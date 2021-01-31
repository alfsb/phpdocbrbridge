
> Essa é uma tradução, com adaptações, do [PHP Manual Contribution Guide](http://doc.php.net/tutorial/). Leitura necessária para quem deseja realizar contribuições maiores ao manual do PHP.

# Introdução

O PHP é bem conhecido por possuir uma documentação excelente. Documentação esta que é criada por voluntários que fazem alterações coletivamente, todos os dias. Este guia foi projetado para as pessoas que trabalham na documentação oficial do PHP.

# Glossário

Esse guia utiliza uma terminologia que você precisa conhecer. Não se preocupe, é simples:

* **autor** - Pessoa que contribui na versão original do manual em inglês;
* **tradutor** - Pessoa que traduz o manual em inglês para outra língua.
* **{LANG}** - O código da linguagem, geralmente o código da língua, podendo estar sufixado por uma variante. Por exemplo, a tradução para Português do Brasil utiliza o código `pt_BR`.

# Entrando para a equipe

Entrar para equipe de Documentação do PHP é um processo simples, mas tem um processo ainda assim. Ele pode ser resumido nos seguintes passos:

## Escrever na *mailing list*

Todas as comunicações oficiais ocorrem em *mailing lists*, portanto você deve se inscrever e comunicar por elas. Mande um "oi" e comente no que está interessado em fazer. Se preferir pode ficar só observando por um tempo, ou ler os arquivos antes, mas não deixe de conversar com a gente.

### Para autores

Você deve escrever uma mensagem para a *maillist* [phpdoc@lists.php.net](mailto:phpdoc@lists.php.net).

### Para tradutores

Para se inscrever na lista da tradução para Português do Brasil mande um email em branco para [doc-pt-br-subscribe@lists.php.net](mailto:doc-pt-br-subscribe@lists.php.net), e para conversar, basta mandar emails para o endereço geral [doc-pt-br@lists.php.net](mailto:doc-pt-br@lists.php.net).

### Altere alguns arquivos, crie alguns *patchs*

Esse passo é requirido para mostrar que você é um humano de verdade, e que deseja trabalhar e que no geral sabe como fazer isso.

<del>A forma mais simples de iniciar é utilizando o [Online Documentation Editor](https://edit.php.net/), que lhe permite logar com um credencial Facebook/Twitter/Google e editar a documentação. Suas alterações serão revisadas  e eventualmente aceitas por alguém que possua acesso ao SVN.</del> <ins>Não tem ninguém cuidando dos patchs enviados para esse ambiente, considerado desde 2016 como abandonado.</ins>

Outra forma é editar ou criar arquivos através da interface do GitHub. A diferença é que é necessário criar uma conta no GitHub, e realizar um *fork* do repositório antes de começar, e cadastrar *pull requests* quando terminar suas alterações.

Caso tenha familiaridade com as ferramentas em linha de comando `SVN` ou `git`, há também os roteiros específicos. Os links abaixo remetem a cada um desses roteiros, para você estudar qual melhor se adapta ao seu estilo de trabalho:

* <del>Roteiro do Editor Online</del>
* [Roteiro do GitHub](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-GitHub)
* [Roteiro do SVN em linha de comando](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-SVN)
* [Roteiro do git em linha de comando](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-Git)

**Nota da tradução:** Esses roteiros são os que de fato tem de ser utilizados pelos tradutores em Português do Brasil. Tendo isso e mente, continue lendo o resto desse guia traduzido, pois ele contém varias questões de projeto e estilo, que devem ser seguidos. Depois de terminar de ler esse guia, escolha um dos roteiros acima, para daí dar os primeiros passos práticos numa tradução.

## Obtendo acesso SVN

Se você sentir que gostou desse tipo de trabalho, e o está realizando regularmente, existe uma forma mais eficiente que é utilizar o SVN diretamente. Isso requer uma credencial PHP.net. Depois de realizar traduções por alguns meses, converse com os tradutores/autores de como solicitar uma.

Mas esse é o último passo. Primeiro é preciso conseguir alterar o manual. A próxima seção explica como obter os fontes do manual e como eles estão estruturados.

# Estrutura dos fontes do manual

## Baixando os fontes

Os fontes do Manual do PHP estão armazenados num repositório Subversion (SVN). Você não precisa de um acesso especial para realizar o *checkout* (baixa dos arquivos), mas precisará de tal acesso se quiser enviar alterações ao servidor. Esse tutorial assume que você tem um conhecimento básico do SVN. Caso contrário você a respeito dessa ferramenta com no livro [Version Control with Subversion](http://svnbook.red-bean.com/).

Para baixar os arquivos do manual, utilize o seguinte comando:

`svn checkout https://svn.php.net/repository/phpdoc/modules/doc-{LANG} phpdoc`

Este comando criará um diretório chamado `phpdoc`, que você pode mudar para o que desejar. Esse diretório irá conter uma pasta com os fontes da linguagem escolhida (chamada `{LANG}`) e uma pasta chamada `doc-base`, contendo alguns utilitários.

Caso vá trabalhar exclusivamente com ferramentas online esse passo não é necessário, pois esses arquivos estarão disponíveis nas próprias ferramentas.

## Estrutura de arquivos

A estrutura dos arquivos fontes do manual é bem intuitiva. A parte mais complicada é a documentação das extensões, que são a maior parte do manual, dado que todas as funções são agrupadas como extensões.

A documentação das extensões estão localizadas em pastas com nome `/phpdoc/{LANG}/reference/nome_da_extensao/`. Por exemplo, a documentação da extensão calendário existe na pasta `/phpdoc/{LANG}/reference/calendar/`. Lá você encontrará vários arquivos.

* `book.xml` - Funciona como um container da extensão, possuindo um prefácio.

* `setup.xml` - Inclui instruções de instalação e documentação sobre configuração.

* `constants.xml` - Lista todas as constantes que a extensão declara, se houver.

* `configure.xml` - Essas informações geralmente existem no arquivo `setup.xml`, mas se esse arquivo existir ele é automagicamente incluído no `setup.xml`.

* `examples.xml` - Exemplos variados da extensão.

* `foo.xml` - Pode ser qualquer coisa relacionada a extensão. Nesse caso é preciso incluí-lo explicitamente através do book.xml.

Uma extensão procedural também possuirá:

* `reference.xml` - Container para as funções, raramente contém informações.

* `functions/` - Pasta com um arquivo XML por função que a extensão declare.

Uma extensão orientada à objetos conterá:

* `classname.xml` - Container para os métodos definidos na classe, contendo também informações básicas sobre a mesma.

* `classname/` Pasta que contém um arquivo XML por método que a classe declare.

Há alguns outros arquivos importantes, não relacionado às extensões.

* `{LANG}/language-defs.ent` - Contém traduções de *entities* utilizados pela linguagem. Por exemplo, os prefixos de capítulos, mas você deve colocar entities utilizados somente por sua linguagem aqui.

* `{LANG}/language-snippets.ent` - Trechos de XML mais longos, traduzidos para a linguagem. Coisas repetitivas como alertas, notas, etc.

* `{LANG}/translation.xml` - Esse arquivo é utilizado para ser um repositório central das traduções, contendo um curto texto introdutório e uma lista de pessoas. Esse arquivo não existe na árvore em Inglês.

#### Somente traduções

Se algum arquivo não existe na sua tradução, o equivalente em Inglês será utilizado na compilação do manual. Isso significa que você *não deve colocar arquivos sem tradução* nos diretórios da tradução. Isso causará confusão na compilação, e poderá fazer que alguns utilitários parar de funcionar.

Alguns arquivos que existem nos fontes originais não devem ser replicados na tradução. Ou por serem arquivos que só tem conteúdo estrutura, sem texto traduzível (arquivos `/reference/*/entities.*.xml`), ou ainda por serem arquivos gerados automaticamente (por exemplo, `/reference/*/versions.xml`). Para lembrar, só devem ser acrescentados arquivos *modificados* na tradução, não replicando arquivos inalterados. Patchs com esse tipo de arquivos são recusados.

# Editando os fontes do manual

Quando for editar os fontes do manual, você tem de lembrar de algumas coisas:

* Utilize somente a codificação UTF-8
* Siga o guia de estilo (abaixo)

## Editando arquivos existentes

Abra os arquivos e os edite. Simples assim.

## Adicionando nova documentação

Para adicionar novos arquivos na documentação original, há algumas opções automatizadas para extensões, explicadas no [PHP Manual Contribution Guide](http://doc.php.net/tutorial/editing.php).

Arquivos inexistentes na tradução mas que existem no original em Inglês, basta criar o arquivo com o mesmo nome,  no mesmo caminho relativo a partir de `phpdoc/{LANG}`. O processo de tradução em si é mais longo, e uma das linhas do arquivo original tem de ser [alterada nas traduções](https://github.com/phpdocbrbridge/traducao/wiki/Tag-de-revis%C3%A3o).

## Validando suas alterações

Cada vez que fizer alterações nos fontes da documentação, seja no Inglês ou numa tradução, você deve validar essas alterações para garantir que o manual esteja compilando sem erros. O script [configure.php](http://svn.php.net/viewvc/phpdoc/doc-base/trunk/configure.php?view=markup) contido no repositório [doc-base](http://svn.php.net/viewvc/phpdoc/doc-base/) realiza essa validação. O que você deve fazer é executá-lo:

```
cd phpdoc
php configure.php --with-lang={LANG}
```

Caso esteja validando os fontes originais você pode omitir o argumento `with-lang`. Quando o processamento acima termina com a mensagem `All good. Saving .manual.xml… done.` então o documento é válido, e você pode então submeter as alterações.

## Enviando suas alterações

Se você tiver o [commit karma](http://svn.php.net/viewvc/SVNROOT/global_avail?view=markup) apropriado, você mesmo pode enviar as alterações. Caso não possua, as alterações podem ser enviadas por vários outros canais:

* Alterações gravadas no Editor Online ou no GitHub aparecem automaticamente para os tradutores com karma revisarem. Lembrar de "enviar" suas alterações, fazendo um [Enviar modificações/Commit](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-Editor-Online#enviar-modifica%C3%A7%C3%B5es) no Editor Online, ou um [*pull request*](https://help.github.com/articles/creating-a-pull-request/) no GitHub
* Alterações locais de um *checkout* SVN podem ser encaminhadas à lista de discussão como [*patchs*](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-SVN).
* Alterações locais de um *checkou* Git podem ser commitadas contra o seu repositório, e depois aberto [*pull requests*](https://github.com/phpdocbrbridge/traducao/wiki/Roteiro-Git) ao repositório ponte.

## Visualizando as alterações online

A documentação é compilada toda noite às 23:00 CST, e então sincronizada em vários sites espelho. Um site espelho especial é o disponível no link [docs.php.net](http://docs.php.net/), onde a compilação do manual é atualizada a cada seis horas. Se algum erro ocorrer, a mensagem é encaminhada para a lista apropriada (`doc-{LANG}@lists.php.net`). Os logs das compilações estão disponíveis no endereço [http://doc.php.net/logs/](http://doc.php.net/logs/).

# Guia de estilo

## Requisitos técnicos

* Todos os arquivos **devem** estar codificados utilizando UTF-8 (sem BOM)

* Utilizar somente fins de linha estilo Unix (`\n`)

**Observação**: Esses requisitos já são cumpridos pelos ferramentas online. Se aplicam especificamente para quem faz edições offline.

## Comprimentos de linha

**Fontes em Inglês:** Tente fazer com que as linhas no XML tenham 80 letras ou menos. Esse é um requisito suave, com 100 letras sendo o máximo aceitável. Isto facilita por deixar os *diffs* simples, o que é muito útil aos tradutores de todas as linguagens. Então siga essa regra cuidadosamente.

**Fontes em Português:** Na tradução para Português do Brasil é sugerido um outro estilo. Tente fazer com que o arquivo traduzido tenha o mesmo *número de linhas* que o arquivo original, em particular, que as linhas contenham (quase) as mesmas tags nas mesmas linhas, nem que para isso as linhas fiquem bem mais compridas que 80~100 letras dos originais. Isso porque o Inglês é uma língua bem mais sisuda que o Português, então igualar o número de linhas em média aumenta o tamanho das linhas individuais. Manter o mesmo número de linhas, e as tags quase nas mesmas linhas entre original e tradução, ajudam enormemente no processo de *atualização* da tradução, então tente sempre fazer isso.

## *Whitespaces*

No XML, endente o código utilizando um espaço apenas. Não use tabs. Para exemplos de código PHP utilize quatro espaços para endentação, pois os exemplos devem aderir ao [PEAR Coding Standards](http://pear.php.net/manual/en/standards.php).

## Pontuação

**Fontes em Inglês**: Pontuação no Manual do PHP segue as regras gramaticais anglófonas. Quando escrevendo sentenças sequenciais, como descrições de funções, pontuação normal deve ser utilizada. Listas, títulos, e fragmentos de sentenças não devem ser pontuadas com ponto final. Sentenças não devem ter dois espaços entre si. Vírgulas e apóstrofos devem ser utilizados apropriadamente.

**Fontes em Português**: O mesmo se aplica, porém utilizando as regras do último Acordo Gramatical. Em específico, não é comum em Português que o conectivo *e* seja precedido de vírgula (ao contrário do parágrafo acima, onde foi copiado o estilo em Inglês) e adjetivos e outros qualificativos precedem o substantivo (em Inglês é o inverso).

## Personalização

O Manual do PHP é um documento técnico, e assim deve estar escrito. O uso de "você" é comum no manual, o que o deixa com uma aparência nada profissional. Somente é permitido a personalização em duas seções: o Tutorial e nas FAQs.

**Exemplo incorreto:** `Você pode utilizar o segundo parâmetro opcional para indicar tags que não devem ser eliminadas.`

**Exemplo correto:** `O segundo parâmetro opcional pode ser utilizado para indicar tags que não devem ser eliminadas.`

## Cronologia

* Quando se referindo a uma versão específica do PHP, não use "desde". Utilize "a partir de".
* Nos changelogs, versões superiores do PHP são mencionadas primeiro.
* Se um changelog se aplica a várias versões do PHP, liste-as separadas por vírgula, a menor aparecendo primeiro. Por exemplo: `<entry>5.2.11, 5.3.1</entry>`

## Gramática geral

**Fontes em Inglês:** O Manual do PHP deve ser escrito com particular atenção à gramática Inglesa. Contrações devem ser utilizadas apropriadamente. Atenção especial deve ser dedicada a construção de sentenças utilizando preposições (no caso, sentenças não devem se encerrar utilizando preposições).

**Fontes em Português:** A gramática a ser seguida é do último Acordo Ortográfico.

## Termos no Manual do PHP

Vários termos não ingleses, técnicos, são utilizados no corpo do manual, sem uma indicação do estilo apropriado a ser utilizado. A lista disponível no [tutorial em inglês](http://doc.php.net/tutorial/style.php) serve para clarear a questão.

Em Português, alguns termos são traduzidos, alguns não. Termos antigos, normalmente utilizados na área não são traduzidos (*string*), termos com equivalentes *comuns* costumam ser (função, exceção), e termos pouco comuns são mantidos no original, ainda que recentes (*thread*, *prefork*).

Infelizmente não existe uma distinção clara (ou vocabulário em lista) do que traduzir ou não, então isso fica por conta da sensibilidade do tradutor. Em último caso, deve-se traduzir os termos quais se espera encontrar numa conversa entre profissionais de informática, em vez da tradução visando um completo iniciante. Por exemplo: *thread* em vez de encadeamento, *trait* em vez caraterística, e assim por diante.

# Apêndices

O [PHP Manual Contribution Guide](http://doc.php.net/tutorial/) contém uma série de apêndices, com informações pontuais. Replicar aqui os dados específicos é contraproducente, de forma que segue uma lista das informações disponíveis, quais fica a sugestão da leitura.

O primeiro apêndice é uma [FAQ](http://doc.php.net/tutorial/faq.php), com informações pertinentes sobre como documentar uma nova extensão, commitar ou não texto padrão, o que fazer se o `configure.php` cair por segfault, como fazer links para métodos de classe, como documentar informações de versionamento, links externos, formatação de notas, documentação de parâmetros opcionais, como lidar com texto repetitivo, e como configurar o Subversion.

Essas são questões mais pertinentes aos editores dos originais do manual. De pertinente à tradução é a FAQ **Do I need to edit these entities* files?**. A resposta é não. Arquivos cujo conteúdo é apenas uma lista de *entities* XML são gerados automaticamente, e não devem ser traduzidos. Mesmo que tal arquivo seja editado manualmente no original (ou seja, está adicionado no SVN) ele não deve ser replicado na tradução.

O segundo apêndice contém detalhes do processo de [compilação do manual](http://doc.php.net/tutorial/builds.php). Horários de sync entre espelhos, nomes das máquinas e seus responsáveis, quais linguagens são compiladas ou estão desativadas e afins.

O terceiro apêndice é bem interesse, e merece uma leitura: [Porque nós nos importamos com espaço em branco](http://doc.php.net/tutorial/whitespace.php). Esse é um padrão que é seguido à risca nos originais, mas que infelizmente nas traduções o negócio é bem mais relaxado. Mas vale a pena saber, e mais, praticar, como uma forma de gerar *diffs bonitos*, e assim ser mais *respeitado* nas comunidades open source.

O [penúltimo apêndice](http://doc.php.net/tutorial/user-notes.php) é um guia de como lidar com as notas de usuário, sua moderação e/ou inclusão no manual. Caso já tenha uma credencial PHP.net, a moderação das notas de usuário é um trabalho sem fim, assim como a própria tradução do manual, e toda ajuda é bem vinda.

O [último apêndice](http://doc.php.net/tutorial/local-setup.php) ensina como levantar um ambiente de compilação e visualização da documentação, ou seja, como recriar os manuais a partir dos fontes, e como criar um espelho da documentação. Mais interessante para quem quer ver o resultado final das traduções, ou para quem está trabalhando especificamente alterações na parte visual do manual.
