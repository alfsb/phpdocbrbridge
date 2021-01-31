### Não há ninguém trabalhando nos patchs do Editor Online. Isso significa que nada que realizar aqui chegará ao manual oficial. Veja outros [Ambientes de Tradução](https://github.com/phpdocbrbridge/traducao/wiki#ambientes-de-tradu%C3%A7%C3%A3o).

<del>

### Começando
Atualmente todas as páginas de manual no [php.net](http://php.net/manual/pt_BR/) possuem links para o editor online, permitindo qualquer um (anonimamente ou não), a edição das páginas do manual. O link está disposto abaixo da seleção de idioma.

![edit](http://i.imgur.com/XIteFHN.png)

O editor também pode ser acessado no endereço: [https://edit.php.net/](https://edit.php.net/)

### Quem pode editar uma página?
* Usuários anônimos podem criar patches;
* Pessoas com contas SVN podem aplicar seus próprios patchs e os de outras pessoas.

### Usuários anônimos
![login](http://i.imgur.com/eDP7atg.png)

Quando a aplicação iniciar, o login padrão será "Anonymous", com o password vazio. Pode-se autenticar-se anonimamente pelos seguintes métodos:

* login e senha vazios;
* sua conta no [Facebook](https://www.facebook.com);
* sua conta no [Github](https://www.github.com);
* sua conta no [Linkedin](https://www.linkedin.com);
* sua conta no [Stackoverflow](https://www.stackoverflow.com);
* sua conta no [Instagram](https://www.instagram.com);

Com sua conta no Facebook/Github/Google/Lindekin/Stackoverflow/Instagram, poderemos identificar os usuários que enviaram patches.

Um usuário anônimo pode editar qualquer página e salvar seu trabalho como um patch. Ao salvar, um e-mail pode ser informado, para notificá-lo quando o patch for aprovado ou removido. Todos os usuários podem visualizar os patches na aba "Pending Patch".

### Usuários com conta no SVN

Usuários com contas no SVN (e seus devidos direitos), podem fazer login com usuário e senha do SVN. Assim será possível:

* modificar informações;
* editar uma página;
* enviar sua modificações;
* enviar patches pendentes de outras pessoas.

## Sobre a tag de revisão

Para facilitar a sincronização entes fontes originais e traduções, há uma linha especial nos arquivos, chamada tag de revisão, ou *revision tag*. Em cada tradução ou atualização essa tag de revisão precisa ser sincronizada, conforme o explicado a seguir:

A linha deve estar no seguinte formato:

```
<!-- EN-Revision: nnnnnn Maintainer: xxxx Status: ssss --><!-- CREDITS: yyyy,zzzz -->
```

Onde:

* `nnnnnn`: É o número que aparece no original, no arquivo em inglês.
* `xxxx`: É o login do tradutor do manual, uma credencial PHP.net. Caso não possua, preencher com `none`.
* `ssss`: É um código de status, conforme abaixo.
* `yyyy,zzzz`: Uma relação de logins dos tradutores com credencial PHP.net. Logins separados por vírgula.

Os valores previstos para o Status são:

* `ready`: Significa que a tradução está pronta.
* `revision`: Significa que a tradução está pronta, mas que o tradutor solicita que outra pessoa revise.
* `wip`: Sigla de *work in progress*, uma tradução que está no meio do caminho. Entre em contato *maintainer* do arquivo ou discuta a situação na lista, caso encontre um arquivo ainda `wip` depois de muito tempo.

Basicamente o que você faz é sincronizar o número da tradução a partir do número no arquivo original e inserir sua credencial na lista CREDITS, se tiver um credencial PHP.net. Se quiser pegar a manutenção do arquivo para si (e se possuir uma credencial PHP.net), você pode substituir o `xxxx` por seu login. Caso não possua uma credencial PHP.net, os créditos são dados na mensagem de commit.

**Observação:** Os scripts de monitoração das traduções utilizam REGEXs bem simples para ler a tag de revisão, então os espaços, ordem e formato geral das tags precisam ser exatamente como nos exemplos acima. De outra forma o script não rastreará corretamente as traduções.

## Todos os módulos (de tradução)

Em Todos os Módulos estão disponíveis todos os idiomas, menos o Inglês, por que os módulos relacionados a tradução (como gráficos relacionados ao percentual de tradução), não fazem sentido para o idioma Inglês.

### Arquivos que necessitam de tradução - Files Needing Translation
![nt](http://i.imgur.com/sqBXVue.png)

Este módulo exibe todos os arquivos disponíveis na documentação no idioma Inglês, que ainda não foram traduzidos para o idioma selecionado.

Dê dois cliques no arquivo para abrí-lo em uma nova aba. O arquivo em Inglês será exibido e você poderá começar a traduzí-lo diretamente.

As tags revcheck e reviewed serão adicionadas automaticamente pelo editor, com o número de revisão, e seu nome como *maintainer*. Contudo, você pode inserí-los pelo menu do arquivo "MarkUp".

Quando tiver modificado o arquivo, você pode enviar seu trabalho (para usuários autenticados pelo SVN) ou salvá-los como patch (para usuários anônimos).

Suas modificações aparecerão, respectivamente, nos módulos "Pending Commit" ou no "Pending Patch".

### Arquivos que necessitam de atualização - Files Need Update
![nu](http://i.imgur.com/xTREcsV.png)

Baseado na tag de revcheck, este módulo lista todos os arquivos que foram modificados na versão em Inglês, mas ainda não foram sincronizados no idioma selecionado. Todos os arquivos são ordenados por diretório, e então por nome do arquivo.

```
<!-- EN-Revision: 288721 Maintainer: felipe Status: ready -->
```

**Não se esqueça** de atualizar manualmente o número EN-Revision para o número da revisão em Inglês do arquivos que se está atualizando.

Dê dois cliques em um arquivo para iniciar sua edição em uma nova aba.
Dê um clique com o botão direito nele para exibir o menu de contexto, que oferece diversas opções.

Assim que começar a editar um arquivo, o painel principal exibirá 4 sub painéis:

* No topo, o diff apresenta todas as modificações feitas no idioma inglês;
* A direita, pode-se observar o log SVN deste arquivo, tanto o da versão em inglês, quanto o do idioma selecionado serão exibidos;
* No centro há dois painéis:
  * Um para o arquivo LANG;
  * Um para o arquivo EN;

Quando tiver modificado o arquivo, você pode salvar seu trabalho (para usuários autenticados pelo SVN), ou salvá-los como patch (para usuários anônimos). Suas modificações aparecerão, respectivamente, nos módulos "Pending Commit" ou no "Pending Patch".

### Erros na tradução atual - Error in current translation
![er](http://i.imgur.com/u7y0CEX.png)

Este módulo apresenta todos os arquivos com erro.
Ao atualizar as informações, várias checagens são feitas em cada arquivo.
Pode-se visualizar todas as verificações feitas clicando com o botão direito no arquivo e selecionado o sub menu "About error type". Esta ação exibirá todos os tipos de erros em uma nova aba.

Ao dar clique duplo em um arquivo desde módulo, uma nova aba será aberta, igual a aba "need update".

* No topo, o tipo de erro deste arquivo.
* A direita, pode-se observar o log SVN deste arquivo, tanto o da versão em Inglês, quanto o do idioma selecionado serão exibidos;
* No centro há dois painéis:
  * Um para o arquivo LANG;
  * Um para o arquivo EN;

Quando tiver modificado o arquivo, você pode salvar seu trabalho (para usuários autenticados pelo SVN), ou salvá-los como patch (para usuários anônimos).

Suas modificações aparecerão, respectivamente, nos módulos "Pending Commit" ou no "Pending Patch".

### Arquivos que precisam de revisão - Files Need Reviewed
![re](http://i.imgur.com/IDgfEPw.png)

Este módulo exibirá todos os arquivos que precisam ser revisados (baseados na tag de revisão).

```
<!-- Reviewed: No -->
```

Um arquivo aparecerá neste módulo quando sincronizado com o arquivo EN, e não possuir a tag review, ou a tag review estiver definida como `No`.

Pode-se fazer um clique duplo em um arquivo para iniciar sua edição em uma nova aba. Dê um clique com o botão direito para exibir o menu de contexto, que oferece outras opções.

Ao iniciar a edição, o painel principal exibirá 3 sub painéis:

* A direita, pode-se observar o log SVN deste arquivo, tanto o da versão em inglês, quanto o do idioma selecionado serão exibidos;
* No centro há dois painéis:
  * Um para o arquivo LANG;
  * Um para o arquivo EN;

Quando tiver modificado o arquivo, você pode salvar seu trabalho (para usuários autenticados pelo SVN), ou salvá-los como patch (para usuários anônimos).

Suas modificações aparecerão, respectivamente, nos módulos "Pending Commit" ou no "Pending Patch".

> O menu de contexto lhe permite abrir todos os arquivos da extensão corrente. Então, você pode revisar todos os arquivos de uma determinada extensão e ser mais consistente em seu trabalho.

### Arquivos que não estão em EN - Not in EN
![ne](http://i.imgur.com/aRN1Sbq.png)

Este módulo lista todos os arquivos que estão em no idioma selecionado, mas não no EN.
Geralmente, isso acontence quando um arquivo é removido da árvore EN, mas não foi sincronizado ainda no idioma selecionado.

Ao fazer um clique duplo uma nova aba será aberta e você poderá ver o conteúdo do arquivo. Não pode ser editado.

Dê um clique direito sobre o arquivo e escolha "Remove this file" para adicioná-lo ao módulo "Pending Commit"

Um usuário anônimo pode marcar o arquivo para remoção, já que será adicionado ao commit.

### Todos os arquivos - All Files
![af](http://i.imgur.com/NMxVwQd.png)

Este módulo lhe permite visualizar todo o repositório do idioma Inglês, ou do idioma selecionado.

É útil quando se deseja editar algum arquivos que é ignorado por outro módulo (como os arquivos `entities.*`, que são gerados automaticamente).

Então, pode-se editar qualquer aqui, salve-o ou marque-o como patch, e então adicione-o ao módulo "Pending Commit".

O menu de contexto lhe permite iniciar a edição do arquivo em uma nova aba, mas também abrirá o mesmo arquivo na árvore EN (se o arquivo for do idioma selecionado), ou no idioma selecionado (se for um arquivo da árvore EN).

### Arquivos pendentes de envio
![pe](http://i.imgur.com/jokgRpr.png)

Este módulo lista todos os arquivos modificados por você, ou por outras pessoas (autenticadas ou não), para o idioma Inglês, e para o idioma selecionado.

Todas as ações (e submenus), depende da localização do arquivo modificado.

#### Arquivos modificados no módulo "Need Translate"
Ao dar um duplo clique neste tipo, o arquivo abrirá como se tivesse sendo aberto no módulo "Need Translate"

As seguintes ações estão disponíveis no menu de contexto:
 - *Edit in a new tab*: Esta é a ação padrão. É o mesmo que dar dois cliques em um arquivo na grade.
 - *Clear this change*: Cancela as modificações.
 - *Commit*: Menu de envio (veja abaixo)

#### Arquivos modificados no módulo "Need Update"
Ao dar um duplo clique neste tipo, o arquivo abrirá como se tivesse sendo aberto no módulo "Need Update"

As seguintes ações estão disponíveis no menu de contexto:
 - *Edit in a new tab*: Esta é a ação padrão. É o mesmo que dar dois cliques em um arquivo na grade.
 - *View diff*: Abre uma aba e exibe a diferença entre a versão original e a versão modificada do arquivo.
 - *Download the diff as a patch*: Abre a janela de download padrão para fazer o download da diferença (diff), como um arquivo patch.
 - *Clear this change*: Cancela as modificações.
 - *Commit*: Menu de envio (veja abaixo)

#### Arquivos modificados no módulo "Error in current translation"
Ao dar um duplo clique neste tipo, o arquivo abrirá como se tivesse sendo aberto no módulo "Error in current translation"

O menu de contexto é idêntico ao menu de contexto de um arquivo modificação no módulo "Need Update".

#### Arquivos modificados no módulo "Files Need Reviewed"
Ao dar um duplo clique neste tipo, o arquivo abrirá como se tivesse sendo aberto no módulo "Files Need Reviewed"

O menu de contexto é idêntico ao menu de contexto de um arquivo modificação no módulo "Need Update".

#### Arquivos modificados no módulo "Not in EN"
Ao dar um duplo clique neste tipo, o arquivo abrirá como se tivesse sendo aberto no módulo "Not in EN"

As seguintes ações estão disponíveis no menu de contexto:
 - *Edit in a new tab*: Esta é a ação padrão. É o mesmo que dar dois cliques em um arquivo na grade. Mostra o conteúdo do arquivo em uma nova aba no modo somente leitura.
 - *Clear this deletion*: Cancela as modificações.
 - *Commit*: Menu de envio (veja abaixo)

#### Arquivos modificados no módulo "All files"
Ao dar um duplo clique neste tipo, o arquivo abrirá como se tivesse sendo aberto no módulo "Files Need Reviewed"

O menu de contexto é idêntico ao menu de contexto de um arquivo modificação no módulo "Need Update".

#### Enviar modificações
Para todos, existe um submenu padrão `Commit...` que lhe permite:

* *Commit this file*: abre a janela de commit com somente um arquivo; o arquivo que você clicou com o botão direito.
* *Commit all files modified by the current user*: abre a janela de commit contendo todos os arquivos modificados pelo usuário atual para o idioma selecionado, e o idioma inglês.
* *Commit all files modified by everyone*:  abre a janela de commit contendo todos os arquivos modificados no idioma selecionado e no idioma inglês.

##### A janela de commit
![jc](http://i.imgur.com/goIY6Us.png)

Esta janela é composta por três painéis:
* A lista de arquivos que deseja-se enviar. Cada arquivo possui um checkbox (checado por padrão), que permite excluí-lo do envio atual, ou não.
* A lista de mensagens de envios anteriores. Cada vez que se envia, por padrão, sua mensagem é salva e pode-se usar o elemento para reuso.
* O espaço para escrever a mensagem de log do commit atual.

Selecione o botão "Submit" para enviar os arquivos selecionado, usando a mensagem como log do VCS.
Quando o envio estiver feito, parte da janela será recarregada, refletindo o novo estado da documentação.

#### Tratando suas mensagens de envio anteriores
![old](http://i.imgur.com/WrqA85w.png)

Na janela de envio, pode-se ver em seu canto superior direito, uma pequena engranagem, que lhe permite tratar suas mensagens de envio anteriores.
Clicar em alguma abrirá uma janela, onde se pode remover / modificar seus logs de mensagens de envio. .

Para remover uma mensagem, clique com o botão direito e selecione "Delete this log message"
Para modificar uma mensagem, clique duas vezes e modifique-a. Então, clique fora do campo para salvá-la automaticamente.

### Patches pendentes
![pp](http://i.imgur.com/xBezOdo.png)
Este módulo lista todos os patches pendentes que estão prontos para ser enviados para o idioma selecionado e para o idioma Inglês.

Assim como no módulo "Pending Commit", deve-se estar autenticado para gerenciar os patches.

Quando der dois cliques em um patch, uma nova aba será aberta, composta por 4 painéis:

* No topo, o diff das versões do arquivo original e modificado
* A esquerda, um painel exibindo as mensagens de log do VCS
* Ao centro, dois paineis:
  * A esquerda, a versão do arquivo com o patch aplicado
  * A direita, a versão original do arquivo

Diretamente no editor do arquivo com o patch aplicado, dois botões estarão disponíveis na barra de ferramentas:
* *Accept this patch and save the file*: O patch desaparecerá do módulo "Pending Patch" e aparecerá no módulo "Pending Commit".
* *Reject the patch*: O patch desaparecerá do módulo "Pending Patch".

Ao aceitar ou rejeitar um path, o usuário receberá um arquivo se deixado um na criação do patch.

</del>
