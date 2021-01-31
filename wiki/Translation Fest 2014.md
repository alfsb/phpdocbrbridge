## Canais de comunicação

* IRC: `irc.freenode.net/phpdocbr`, com interface web em `https://webchat.freenode.net/?channels=phpdocbr`

* Gitter: `https://gitter.im/phptranslationfestbrasil/chat`

* Trello: `https://trello.com/b/j6Nuulpn/lista-de-tarefas-traducao-pt-br`

## Preparação de ambiente

Ver [Setting up Documentation environment](http://doc.php.net/tutorial/local-setup.php).

### Instalar as dependências no Ubuntu (e similares)

```
source <(wget -qO- https://gist.github.com/royopa/599259ebeffa6ab7b1cb/raw/)
```

### Ambientes prontos (virtualização)

## Máquina Virtual (Virtual Box, VMWare)
Baixe a máquina virtual de sua preferência nos endereços abaixo.

### Máquina Virtual Ubuntu 14.04 32bits (3,8Gb)
> **md5sum** - 83c4947594ebdae38dc4ec515eef94c7<br>
> **Usuário** - root<br>
> **Senha** -  translationfest<br>
> **Localização** - https://drive.google.com/file/d/0BzJtYovThzl_ZEdlTVVvQXpWR2c/view?usp=sharing

Nessa maquina ainda é preciso instalar o package_php antes de compilar o manual, você pode fazer isso da seguinte forma:

`cd ~/translation_fest/phd`<br/>
`sudo pear install package_php.xml`

### Máquina Virtual xUbuntu 14.04 64bits (1,6Gb)

> md5sum ad167d8953a36996d14f422f2942538f<br/>
> **Usuário** xubuntu | **Senha** reverse<br/>
> **Usuário** root | **Senha** reverse<br/>
> https://dl.dropboxusercontent.com/u/3528005/xUbuntu64.7z<br/>

Nessa maquina ainda é preciso instalar o package_php antes de compilar o manual, você pode fazer isso da seguinte forma:

`cd ~/translation_fest/phd`<br/>
`sudo pear install package_php.xml`

### Máquina Virtual xUbuntu 14.04 32bits (2,0Gb)

> **md5sum** - 494e45601657efe973d1b1f19853b4f9<br/>
> **Usuário** -  xubuntu | **Senha** -  reverse<br/>
> **Usuário** -  root | **Senha** -  reverse<br/>
> https://drive.google.com/file/d/0BxhT5kE991U5VmdCRHlDbHd4LTQ/view?usp=sharing

Nessa maquina ainda é preciso instalar o package_php antes de compilar o manual, você pode fazer isso da seguinte forma:

`cd ~/translation_fest/phd`<br/>
`sudo pear install package_php.xml`

### Máquina Virtual centOS 7 64bits (740Mb)

> **md5sum** - 3794c55e94de29a4001ecaec2ce1cc50<br/>
> **shasum** - 678c97df3d059ad784035a9a2cb7c299d0fefb1d<br/>
> **Usuário** - root **Senha** - tfest
> https://www.dropbox.com/s/g8olctbyje9o5lg/TranslationPHP.ova?dl=0

Existe um compartilhamento nfs na pasta /root/translationfest para que a máquina host possa ler os arquivos. Basta montar como um compartilhamento de rede. Funciona em Windows/Linux/Mac.

## Mini tutorial

#### Atualize o repositório svn da documentação

Assim que iniciar o trabalho em qualquer dos ambientes escolhidos, atualize o repositório svn da documentação, com o comando:

```
cd ~/translation_fest/doc-pt_BR
svn up
```

#### Compilando o manual

Para compilar, existem algumas opções:

##### Documentação no formato xHTML

Gera arquivos no formato xHTML, sem imagens, porém funcional:

```
cd ~/doc-pt_BR/
php doc-base/configure.php --enable-xml-details --with-lang=pt_BR
phd --docbook doc-base/.manual.xml --package PHP --format xhtml --output mydocs_xhtml
```

Agora inicie o servidor web do PHP para acessar a documentação pelo navegador:

```
php -S localhost:8000 -t ./mydocs_xhtml/php-chunked-xhtml
```
E acesse a documentação gerada através do endereço [http://localhost:8000/](http://localhost:8000/)

Veja esse processo rodando aqui: [https://asciinema.org/a/14378](https://asciinema.org/a/14378)

<https://asciinema.org/a/14378>

##### Documentação no formato PHP

```
cd ~/doc-pt_BR/
php doc-base/configure.php --enable-xml-details --with-lang=pt_BR
phd --docbook doc-base/.manual.xml --package PHP --format php --output mydocsphp_pt_BR
```

Depois de executar os passos acima, utilize os comandos abaixo para baixar as dependências que o formato de documentação em PHP possui:

```
wget https://github.com/php/web-php/archive/master.zip
unzip master.zip
rm -rf master.zip
rsync -avzC --timeout=600 --delete --delete-after --exclude='distributions/**' --exclude='extra/**' --exclude='backend/notes/**' ./web-php-master/ ./myphpnet/
rm -rf web-php-master/
```

Então mova a pasta da versão da documentação que você criou para dentro da pasta que será usada pelo servidor web:

```
mv mydocsphp_pt_BR/php-web/ myphpnet/manual/pt_BR
```

Agora inicie o servidor web do PHP para acessar a documentação pelo navegador:

```
php -S localhost:8000 -t ./myphpnet/
```

E acesse a documentação gerada através do endereço <http://localhost:8000/manual/pt_BR/>

Veja esse processo rodando aqui: <https://asciinema.org/a/14385>

#### Criando um patch com as suas alterações

Depois de terminar suas alterações de tradução e testá-las, você deve fazer um patch com essas alterações.

Para evitar mandar algum patch que mexa na estrutura do original do manual, é sugerido que o patch seja gerado a partir da pasta pt_BR. Depois de navegar para essa pasta, execute o seguinte comando:

```
svn diff > minha_traducao.patch
```

Pronto. Basta mandar esse patch para a lista <doc-pt-br@lists.php.net> e alguém irá aplicá-lo caso esteja acordo com o foco da tradução e as regras mencionadas no manual.

Não esqueça de mandar uma commit message junto! ex.:

```
Translating the Windows install FAQ [Fulano de Tal <fulano@tal.com>]
```

Quanto mais patches seus forem aprovados, mais fácil para você conseguir uma conta VCS aprovada (SVN, nome@php.net) e agilizar o processo, pois você mesmo vai poder mesclar suas alterações.
