CREATE TABLE Utilizador (ID_User int(10) NOT NULL AUTO_INCREMENT, User_Name varchar(255) NOT NULL, Name varchar(255) NOT NULL, Data_Nascimento date NOT NULL, Password varchar(255) NOT NULL, CC int(10) NOT NULL, Email varchar(255) NOT NULL, MoradaID_Morada int(10) NOT NULL, AprovacaoID_aprovacao int(10), cartaoID_Cartao int(10), TipoUserID_TipoUser int(11) NOT NULL, ImagemID_Imagem int(11) NOT NULL, Status_UtilizadorID_status_utilizador int(10) NOT NULL, PRIMARY KEY (ID_User));
CREATE TABLE Morada (ID_Morada int(10) NOT NULL AUTO_INCREMENT, Rua varchar(255), PRIMARY KEY (ID_Morada));
CREATE TABLE TipoUser (ID_TipoUser int(11) NOT NULL AUTO_INCREMENT, Descrição_TipoUtilizador varchar(255), PRIMARY KEY (ID_TipoUser));
CREATE TABLE Tipo_Item (ID_Tipo int(10) NOT NULL AUTO_INCREMENT, Descricao_TipoItem varchar(255), PRIMARY KEY (ID_Tipo));
CREATE TABLE Mensagem (ID_Mensagem int(10) NOT NULL AUTO_INCREMENT, Conteudo varchar(255), Data_mensagem timestamp NULL, ItemID_Item int(10) NOT NULL, Status_MensagemID_Status_Mensagem int(10) NOT NULL, PRIMARY KEY (ID_Mensagem));
CREATE TABLE Avaliacao (Id_Avaliacao int(10) NOT NULL AUTO_INCREMENT, Comentario varchar(255), Data_Avaliacao timestamp NULL, NotaID_Nota int(10) NOT NULL, OrdemID_Produto int(10) NOT NULL, AprovacaoID_aprovacao int(10) NOT NULL, PRIMARY KEY (Id_Avaliacao));
CREATE TABLE Status_Mensagem (ID_Status_Mensagem int(10) NOT NULL AUTO_INCREMENT, Descricao_status_mensagem varchar(255), PRIMARY KEY (ID_Status_Mensagem));
CREATE TABLE Nota (ID_Nota int(10) NOT NULL AUTO_INCREMENT, Descricao_nota varchar(255), PRIMARY KEY (ID_Nota));
CREATE TABLE Aprovacao (ID_aprovacao int(10) NOT NULL AUTO_INCREMENT, Comentario varchar(255), Data_Submissao timestamp NULL, Data_Aprovacao timestamp NULL, UtilizadorID_Admin int(10) NOT NULL, Status_AprovacaoID_Status_Aprovacao int(11) NOT NULL, PRIMARY KEY (ID_aprovacao));
CREATE TABLE Cartao (ID_Cartao int(10) NOT NULL AUTO_INCREMENT, Numero int(10) NOT NULL, CVC int(11) NOT NULL, Data date NOT NULL, PRIMARY KEY (ID_Cartao));
CREATE TABLE Compra (ID_Compra int(10) NOT NULL AUTO_INCREMENT, Data timestamp NULL, UtilizadorID_User int(10) NOT NULL, AnuncioID_Anuncio int(10) NOT NULL, PRIMARY KEY (ID_Compra));
CREATE TABLE Categoria (ID_Categoria int(11) NOT NULL AUTO_INCREMENT, Descricao_Categoria varchar(255), PRIMARY KEY (ID_Categoria));
CREATE TABLE TIpo_notificacao (ID_TipoNotificacao int(11) NOT NULL AUTO_INCREMENT, Descricao varchar(255), PRIMARY KEY (ID_TipoNotificacao));
CREATE TABLE Pagamento (ID_Pagamento int(11) NOT NULL AUTO_INCREMENT, Valor int(11), Data date, CompraID_Compra int(10) NOT NULL, PRIMARY KEY (ID_Pagamento));
CREATE TABLE Imagem (ID_Imagem int(11) NOT NULL AUTO_INCREMENT, Caminho varchar(255), PRIMARY KEY (ID_Imagem));
CREATE TABLE Item_Imagem (ItemID_Item int(10) NOT NULL, ImagemID_Imagem int(11) NOT NULL, PRIMARY KEY (ItemID_Item, ImagemID_Imagem));
CREATE TABLE Troca (ID_Troca int(11) NOT NULL AUTO_INCREMENT, DataTroca timestamp NULL, ItemID_ItemOferecido int(10) NOT NULL, ItemID_Solicitado int(10) NOT NULL, Status_TrocaID_Status_Troca int(11) NOT NULL, PRIMARY KEY (ID_Troca));
CREATE TABLE Notificacao (ID_Notificacao int(11) NOT NULL AUTO_INCREMENT, Mensagem varchar(255), DataNotificacao timestamp NULL, ReferenciaID int(11), UtilizadorID_User int(10) NOT NULL, ReferenciaTipoID_ReferenciaTipo int(11) NOT NULL, TIpo_notificacaoID_TipoNotificacao int(11) NOT NULL, PRIMARY KEY (ID_Notificacao));
CREATE TABLE ReferenciaTipo (ID_ReferenciaTipo int(11) NOT NULL AUTO_INCREMENT, Descricao varchar(255), PRIMARY KEY (ID_ReferenciaTipo));
CREATE TABLE Reclamacao (ID_Reclamacao int(11) NOT NULL AUTO_INCREMENT, Descricao varchar(255), DataReclamacao timestamp NULL, AprovacaoID_aprovacao int(10) NOT NULL, Status_ReclamacaoID_Status_Reclamacao int(11) NOT NULL, PRIMARY KEY (ID_Reclamacao));
CREATE TABLE Compra_Reclamacao (CompraID_Compra int(10) NOT NULL, ReclamacaoID_Reclamacao int(11) NOT NULL, PRIMARY KEY (CompraID_Compra, ReclamacaoID_Reclamacao));
CREATE TABLE Mensagem_Utilizador (MensagemID_Mensagem int(10) NOT NULL, UtilizadorID_User int(10) NOT NULL, PRIMARY KEY (MensagemID_Mensagem, UtilizadorID_User));
CREATE TABLE Status_Troca (ID_Status_Troca int(11) NOT NULL AUTO_INCREMENT, Descricao_status_troca varchar(255), PRIMARY KEY (ID_Status_Troca));
CREATE TABLE Status_Aprovacao (ID_Status_Aprovacao int(11) NOT NULL AUTO_INCREMENT, Descricao_Status_aprovacao varchar(255), PRIMARY KEY (ID_Status_Aprovacao));
CREATE TABLE Status_Reclamacao (ID_Status_Reclamacao int(11) NOT NULL AUTO_INCREMENT, Descricao_status_reclamacao varchar(255), PRIMARY KEY (ID_Status_Reclamacao));
CREATE TABLE Status_Utilizador (ID_status_utilizador int(10) NOT NULL AUTO_INCREMENT, Descricao_status_utilizador varchar(255), PRIMARY KEY (ID_status_utilizador));
CREATE TABLE Anuncio (ID_Anuncio int(10) NOT NULL AUTO_INCREMENT, Titulo varchar(255), Descricao varchar(255), Preco decimal(6, 2), UtilizadorID_User int(10) NOT NULL, AprovacaoID_aprovacao int(10) NOT NULL, Tipo_ItemID_Tipo int(10) NOT NULL, CategoriaID_Categoria int(11) NOT NULL, Status_AnuncioID_Status_Anuncio int(11) NOT NULL, PRIMARY KEY (ID_Anuncio));
CREATE TABLE Status_Anuncio (ID_Status_Anuncio int(11) NOT NULL AUTO_INCREMENT, Descricao_status_anuncio varchar(255), PRIMARY KEY (ID_Status_Anuncio));
ALTER TABLE Utilizador ADD CONSTRAINT FKUtilizador680017 FOREIGN KEY (MoradaID_Morada) REFERENCES Morada (ID_Morada);
ALTER TABLE Avaliacao ADD CONSTRAINT FKAvaliacao214094 FOREIGN KEY (NotaID_Nota) REFERENCES Nota (ID_Nota);
ALTER TABLE Avaliacao ADD CONSTRAINT FKAvaliacao460566 FOREIGN KEY (AprovacaoID_aprovacao) REFERENCES Aprovacao (ID_aprovacao);
ALTER TABLE Utilizador ADD CONSTRAINT FKUtilizador462334 FOREIGN KEY (AprovacaoID_aprovacao) REFERENCES Aprovacao (ID_aprovacao);
ALTER TABLE Utilizador ADD CONSTRAINT FKUtilizador373700 FOREIGN KEY (cartaoID_Cartao) REFERENCES Cartao (ID_Cartao);
ALTER TABLE Avaliacao ADD CONSTRAINT FKAvaliacao286296 FOREIGN KEY (OrdemID_Produto) REFERENCES Compra (ID_Compra);
ALTER TABLE Compra ADD CONSTRAINT FKCompra155813 FOREIGN KEY (UtilizadorID_User) REFERENCES Utilizador (ID_User);
ALTER TABLE Item_Imagem ADD CONSTRAINT FKItem_Image648731 FOREIGN KEY (ImagemID_Imagem) REFERENCES Imagem (ID_Imagem);
ALTER TABLE Utilizador ADD CONSTRAINT FKUtilizador979318 FOREIGN KEY (TipoUserID_TipoUser) REFERENCES TipoUser (ID_TipoUser);
ALTER TABLE Notificacao ADD CONSTRAINT FKNotificaca913403 FOREIGN KEY (UtilizadorID_User) REFERENCES Utilizador (ID_User);
ALTER TABLE Notificacao ADD CONSTRAINT FKNotificaca154395 FOREIGN KEY (ReferenciaTipoID_ReferenciaTipo) REFERENCES ReferenciaTipo (ID_ReferenciaTipo);
ALTER TABLE Aprovacao ADD CONSTRAINT FKAprovacao495119 FOREIGN KEY (UtilizadorID_Admin) REFERENCES Utilizador (ID_User);
ALTER TABLE Reclamacao ADD CONSTRAINT FKReclamacao876623 FOREIGN KEY (AprovacaoID_aprovacao) REFERENCES Aprovacao (ID_aprovacao);
ALTER TABLE Notificacao ADD CONSTRAINT FKNotificaca714377 FOREIGN KEY (TIpo_notificacaoID_TipoNotificacao) REFERENCES TIpo_notificacao (ID_TipoNotificacao);
ALTER TABLE Compra_Reclamacao ADD CONSTRAINT FKCompra_Rec509146 FOREIGN KEY (CompraID_Compra) REFERENCES Compra (ID_Compra);
ALTER TABLE Compra_Reclamacao ADD CONSTRAINT FKCompra_Rec211866 FOREIGN KEY (ReclamacaoID_Reclamacao) REFERENCES Reclamacao (ID_Reclamacao);
ALTER TABLE Pagamento ADD CONSTRAINT FKPagamento115243 FOREIGN KEY (CompraID_Compra) REFERENCES Compra (ID_Compra);
ALTER TABLE Utilizador ADD CONSTRAINT FKUtilizador772568 FOREIGN KEY (ImagemID_Imagem) REFERENCES Imagem (ID_Imagem);
ALTER TABLE Mensagem_Utilizador ADD CONSTRAINT FKMensagem_U481429 FOREIGN KEY (MensagemID_Mensagem) REFERENCES Mensagem (ID_Mensagem);
ALTER TABLE Mensagem_Utilizador ADD CONSTRAINT FKMensagem_U307261 FOREIGN KEY (UtilizadorID_User) REFERENCES Utilizador (ID_User);
ALTER TABLE Troca ADD CONSTRAINT FKTroca415305 FOREIGN KEY (Status_TrocaID_Status_Troca) REFERENCES Status_Troca (ID_Status_Troca);
ALTER TABLE Aprovacao ADD CONSTRAINT FKAprovacao52084 FOREIGN KEY (Status_AprovacaoID_Status_Aprovacao) REFERENCES Status_Aprovacao (ID_Status_Aprovacao);
ALTER TABLE Mensagem ADD CONSTRAINT FKMensagem481071 FOREIGN KEY (Status_MensagemID_Status_Mensagem) REFERENCES Status_Mensagem (ID_Status_Mensagem);
ALTER TABLE Reclamacao ADD CONSTRAINT FKReclamacao606601 FOREIGN KEY (Status_ReclamacaoID_Status_Reclamacao) REFERENCES Status_Reclamacao (ID_Status_Reclamacao);
ALTER TABLE Mensagem ADD CONSTRAINT FKMensagem252913 FOREIGN KEY (ItemID_Item) REFERENCES Anuncio (ID_Anuncio);
ALTER TABLE Item_Imagem ADD CONSTRAINT FKItem_Image234733 FOREIGN KEY (ItemID_Item) REFERENCES Anuncio (ID_Anuncio);
ALTER TABLE Troca ADD CONSTRAINT FKTroca249283 FOREIGN KEY (ItemID_ItemOferecido) REFERENCES Anuncio (ID_Anuncio);
ALTER TABLE Troca ADD CONSTRAINT FKTroca815193 FOREIGN KEY (ItemID_Solicitado) REFERENCES Anuncio (ID_Anuncio);
ALTER TABLE Compra ADD CONSTRAINT FKCompra629584 FOREIGN KEY (AnuncioID_Anuncio) REFERENCES Anuncio (ID_Anuncio);
ALTER TABLE Anuncio ADD CONSTRAINT FKAnuncio623345 FOREIGN KEY (UtilizadorID_User) REFERENCES Utilizador (ID_User);
ALTER TABLE Anuncio ADD CONSTRAINT FKAnuncio107882 FOREIGN KEY (AprovacaoID_aprovacao) REFERENCES Aprovacao (ID_aprovacao);
ALTER TABLE Anuncio ADD CONSTRAINT FKAnuncio47220 FOREIGN KEY (Tipo_ItemID_Tipo) REFERENCES Tipo_Item (ID_Tipo);
ALTER TABLE Anuncio ADD CONSTRAINT FKAnuncio617781 FOREIGN KEY (CategoriaID_Categoria) REFERENCES Categoria (ID_Categoria);
ALTER TABLE Anuncio ADD CONSTRAINT FKAnuncio546000 FOREIGN KEY (Status_AnuncioID_Status_Anuncio) REFERENCES Status_Anuncio (ID_Status_Anuncio);
ALTER TABLE Utilizador ADD CONSTRAINT FKUtilizador244028 FOREIGN KEY (Status_UtilizadorID_status_utilizador) REFERENCES Status_Utilizador (ID_status_utilizador);
