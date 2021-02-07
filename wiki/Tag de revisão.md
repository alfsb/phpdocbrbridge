
Para facilitar a sincronização entes fontes originais e traduções há uma linha especial nos arquivos, chamada *revision tag* (tag de revisão). Em cada tradução ou atualização essa tag de revisão precisa ser sincronizada, conforme o explicado a seguir.

Nos **originais** a linha tem o seguinte formato:

```
<!-- $Revision: nnnnnn $ -->
```

Nos **arquivos traduzidos** essa linha deve ser **substituída** por uma linha no formato:

```
<!-- EN-Revision: nnnnnn Maintainer: xxxx Status: ssss --><!-- CREDITS: yyyy,zzzz -->
```

Onde:

* `nnnnnn`: É o número que aparece no original, no arquivo em inglês.
* `xxxx`: É o login do tradutor do manual, uma credencial php.net. Caso não possua, preencher com `none`.
* `ssss`: É um código de status, conforme abaixo.
* `yyyy,@zzzz`: Uma relação de logins dos tradutores com credencial php.net ou GitHub. Logins separados por vírgula. Usuários GitHub prefixados com `@` (arroba).

Os valores previstos para o Status são:

* `ready`: Significa que a tradução está pronta.
* `revision`: Significa que a tradução está pronta, mas que o tradutor solicita que outra pessoa revise.
* `wip`: Sigla de *work in progress*, uma tradução que está no meio do caminho. Entre em contato *maintainer* do arquivo ou discuta a situação na lista, caso encontre um arquivo ainda `wip` depois de muito tempo.

Basicamente o `Maintainer` indica a pessoa que por último traduziu ou atualizou o arquivo. Deve estar sempre preenchido, e no caso de você não tiver uma credencial php.net, preencher com o seu login GitHub na forma `@login`. Em `CREDITS` deve constar a lista, separada por vírgula, de todas as pessoas que contribuíram no arquivo, inclusive o `Maintainer` atual. Sempre se credite no `CREDITS`, e no caso de pegar o `Maintainer` para si, verificar se o `Maintainer` original está creditado também.

Os scripts de monitoração das traduções utilizam expressões regulares (regex) bem simples para ler a tag de revisão, de forma então que os espaços, ordem e formato geral das tags precisam ser exatamente como nos exemplos acima. De outra forma o script não rastreará corretamente as traduções.
