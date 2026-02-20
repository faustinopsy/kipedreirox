-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: kipedreiro
-- ------------------------------------------------------
-- Server version	9.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_agendamento`
--

DROP TABLE IF EXISTS `tbl_agendamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_agendamento` (
  `id_agendamento` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `data_solicitada` datetime DEFAULT NULL,
  `total_agendamento` decimal(10,2) DEFAULT NULL,
  `status_agendamento` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id_agendamento`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `tbl_agendamento_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_agendamento`
--

LOCK TABLES `tbl_agendamento` WRITE;
/*!40000 ALTER TABLE `tbl_agendamento` DISABLE KEYS */;
INSERT INTO `tbl_agendamento` VALUES (1,1,'2025-06-12 09:00:00',0.00,'Realizado','2025-06-10 11:00:00'),(2,2,'2025-05-22 14:00:00',50.00,'Realizado','2025-05-20 09:30:00'),(3,3,'2025-08-15 10:00:00',0.00,'Agendado','2025-08-10 16:45:00'),(4,4,'2025-07-17 11:00:00',0.00,'Realizado','2025-07-15 10:00:00'),(5,5,'2025-07-02 08:30:00',80.00,'Cancelado','2025-07-01 14:00:00'),(6,6,'2025-08-14 09:00:00',0.00,'Agendado','2025-08-11 18:00:00'),(7,7,'2025-06-26 15:00:00',0.00,'Realizado','2025-06-25 13:20:00'),(8,8,'2025-08-04 13:00:00',0.00,'Realizado','2025-08-01 10:15:00'),(9,9,'2025-08-16 16:00:00',50.00,'Agendado','2025-08-09 11:00:00'),(10,10,'2025-08-14 10:30:00',0.00,'Agendado','2025-08-12 10:00:00'),(11,1,'2025-07-24 09:00:00',0.00,'Realizado','2025-07-22 17:00:00'),(12,12,'2025-04-12 14:00:00',0.00,'Realizado','2025-04-10 08:00:00'),(13,13,'2025-06-01 09:00:00',120.00,'Cancelado','2025-05-30 11:30:00'),(14,14,'2025-08-07 10:00:00',0.00,'Realizado','2025-08-05 15:00:00'),(15,15,'2025-08-18 11:30:00',0.00,'Agendado','2025-08-11 19:00:00'),(16,3,'2025-07-18 10:00:00',0.00,'Realizado','2025-07-18 08:10:00'),(17,5,'2025-08-02 16:00:00',0.00,'Realizado','2025-08-02 13:00:00'),(18,7,'2025-08-19 09:00:00',0.00,'Agendado','2025-08-12 11:45:00'),(19,9,'2025-06-16 14:00:00',0.00,'Cancelado','2025-06-15 12:00:00'),(20,11,'2025-08-11 09:30:00',50.00,'Agendado','2025-08-08 17:30:00');
/*!40000 ALTER TABLE `tbl_agendamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_avaliacao`
--

DROP TABLE IF EXISTS `tbl_avaliacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_avaliacao` (
  `id_avaliacao` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_item_orcamento` int DEFAULT NULL,
  `descricao_avaliacao` text COLLATE utf8mb4_general_ci,
  `nota_avaliacao` int DEFAULT NULL,
  `status_avaliacao` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_item_orcamento` (`id_item_orcamento`),
  CONSTRAINT `tbl_avaliacao_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_usuario` (`id_usuario`),
  CONSTRAINT `tbl_avaliacao_ibfk_2` FOREIGN KEY (`id_item_orcamento`) REFERENCES `tbl_item_orcamento` (`id_item_orcamento`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_avaliacao`
--

LOCK TABLES `tbl_avaliacao` WRITE;
/*!40000 ALTER TABLE `tbl_avaliacao` DISABLE KEYS */;
INSERT INTO `tbl_avaliacao` VALUES (1,2,NULL,'Serviço elétrico impecável! O profissional foi muito cuidadoso e resolveu tudo rapidamente. Recomendo!',5,'Aprovada','2025-06-06 10:00:00'),(2,7,NULL,'A instalação das tomadas foi bem feita. Profissional pontual e educado.',4,'Aprovada','2025-07-11 11:00:00'),(3,12,NULL,'O reboco ficou perfeito. Trabalho limpo e entregue no prazo.',5,'Aprovada','2025-04-26 09:00:00'),(4,3,NULL,'O vazamento foi resolvido, mas o profissional se atrasou um pouco.',3,'Aprovada','2025-07-21 14:00:00'),(5,5,NULL,'Instalação do chuveiro foi super rápida. Excelente serviço!',5,'Aprovada','2025-08-04 09:30:00'),(6,1,NULL,'O muro está sendo construído e o trabalho até agora está excelente. Equipe muito profissional.',5,'Pendente','2025-07-15 18:00:00'),(7,4,NULL,'O profissional veio, identificou o problema e já estou aguardando o reparo final. Atendimento inicial foi ótimo.',4,'Aprovada','2025-07-18 10:00:00'),(8,8,NULL,'A aplicação da textura ficou linda, deu outra vida para a sala. Adorei!',5,'Aprovada','2025-08-10 19:00:00'),(9,1,NULL,'A pintura da fachada está na metade e já vejo a qualidade do serviço. Muito bom.',4,'Pendente','2025-08-01 12:00:00'),(10,14,NULL,'A demolição foi feita com muito cuidado para não afetar o resto da estrutura. Satisfeito.',5,'Aprovada','2025-08-08 17:00:00'),(11,2,NULL,'Esqueci de mencionar que o preço também foi justo. Valeu muito a pena.',5,'Reprovada','2025-06-07 10:00:00'),(12,12,NULL,'Serviço de qualidade.',4,'Aprovada','2025-04-27 11:00:00'),(13,7,NULL,'Bom trabalho.',4,'Aprovada','2025-07-12 13:00:00'),(14,1,NULL,'Profissional muito competente.',5,'Pendente','2025-07-20 10:00:00'),(15,4,NULL,'O atendimento poderia ser mais rápido, mas o serviço foi bom.',3,'Aprovada','2025-07-19 16:00:00'),(16,8,NULL,'Adorei o resultado final. Ficou melhor que o esperado.',5,'Aprovada','2025-08-11 09:00:00'),(17,3,NULL,'Resolvido.',3,'Aprovada','2025-07-22 11:00:00'),(18,5,NULL,'Serviço rápido e eficiente.',5,'Aprovada','2025-08-05 15:00:00'),(19,1,NULL,'Recomendo a equipe de pintura.',4,'Pendente','2025-08-05 14:00:00'),(20,14,NULL,'Tudo certo com a demolição.',4,'Aprovada','2025-08-09 13:00:00');
/*!40000 ALTER TABLE `tbl_avaliacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_categoria`
--

DROP TABLE IF EXISTS `tbl_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao_categoria` text COLLATE utf8mb4_general_ci,
  `foto_categoria` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categoria`
--

LOCK TABLES `tbl_categoria` WRITE;
/*!40000 ALTER TABLE `tbl_categoria` DISABLE KEYS */;
INSERT INTO `tbl_categoria` VALUES (1,'Alvenaria','Serviços de construção e reparo de paredes, muros e estruturas de tijolos ou blocos.','foto_alvenaria.webp'),(2,'Pintura','Pintura de interiores e exteriores, aplicação de texturas e acabamentos especiais.','foto_pintura.webp'),(3,'Elétrica','Instalação e manutenção de sistemas elétricos, fiação, tomadas e quadros de luz.','foto_eletrica.webp'),(4,'Hidráulica','Reparos e instalação de encanamentos, torneiras, caixas d\'água e sistemas de esgoto.','foto_hidraulica.webp'),(5,'Carpintaria','Criação e reparo de estruturas de madeira, como telhados, portas, janelas e móveis planejados.','foto_carpintaria.webp'),(6,'Jardinagem','Manutenção de jardins, poda de árvores, plantio de grama e paisagismo.','foto_jardinagem.webp'),(7,'Gesso e Drywall','Instalação de forros, sancas e paredes de gesso ou drywall para acabamentos internos.','foto_gesso.webp'),(8,'Revestimentos','Aplicação de pisos, azulejos, porcelanatos e outros tipos de revestimentos em paredes e chãos.','foto_revestimentos.webp'),(9,'Impermeabilização','Serviços para proteger lajes, paredes e fundações contra infiltrações de água.','foto_impermeabilizacao.webp'),(10,'Serralheria','Fabricação e instalação de portões, grades, corrimãos e outras estruturas metálicas.','foto_serralheria.webp'),(11,'Limpeza Pós-Obra','Limpeza especializada para remover resíduos de construção e deixar o imóvel pronto para uso.','foto_limpeza.webp'),(12,'Ar Condicionado','Instalação e manutenção de sistemas de climatização e ar condicionado.','foto_ar_condicionado.webp'),(13,'Marcenaria','Criação de móveis sob medida e projetos personalizados em madeira.','foto_marcenaria.webp'),(14,'Vidraçaria','Instalação de vidros em janelas, portas, boxes de banheiro e espelhos.','foto_vidracaria.webp'),(15,'Demolição','Serviços de demolição controlada de estruturas e remoção de entulho.','foto_demolicao.webp'),(16,'Automação Residencial','Instalação de sistemas inteligentes para controle de iluminação, segurança e eletrônicos.','foto_automacao.webp'),(17,'Segurança Eletrônica','Instalação de câmeras de segurança (CFTV), alarmes e cercas elétricas.','foto_seguranca.webp'),(18,'Telhados e Calhas','Construção, reparo e limpeza de telhados e sistemas de calhas.','foto_telhados.webp'),(19,'Fundações','Serviços de escavação, concretagem e construção de fundações para edificações.','foto_fundacoes.webp'),(20,'Consultoria de Obra','Acompanhamento e gerenciamento de projetos de reforma ou construção por um especialista.','foto_consultoria.webp');
/*!40000 ALTER TABLE `tbl_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contato`
--

DROP TABLE IF EXISTS `tbl_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_contato` (
  `id_contato` int NOT NULL AUTO_INCREMENT,
  `nome_contato` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone_contato` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_contato` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `assunto_contato` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mensagem_contato` text COLLATE utf8mb4_general_ci,
  `status_contato` varchar(10) COLLATE utf8mb4_general_ci DEFAULT 'Novo',
  `data_envio` datetime DEFAULT NULL,
  `lido` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_contato`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contato`
--

LOCK TABLES `tbl_contato` WRITE;
/*!40000 ALTER TABLE `tbl_contato` DISABLE KEYS */;
INSERT INTO `tbl_contato` VALUES (1,'Juliana Almeida','(11) 98765-432','juliana.a@emailaleatorio.com',NULL,'Gostaria de um orçamento para pintura de um apartamento de 2 quartos. Qual o procedimento?','Novo','2025-08-13 08:24:54',0),(2,'Márcio Vilela','(21) 91234-567','marcio.v@emailaleatorio.com',NULL,'Vocês fazem pequenos reparos hidráulicos? Tenho um vazamento na pia da cozinha.','Respondido','2025-08-12 08:24:54',0),(3,'Fernanda Lima','(31) 99988-776','fernanda.lima@emailaleatorio.com',NULL,'Preciso de um eletricista com urgência. Meu chuveiro não está esquentando.','Lido','2025-08-14 03:24:54',0),(4,'Rogério Bastos','(51) 98877-665','rogerio.b@emailaleatorio.com',NULL,'Quero saber mais sobre o serviço de jardinagem. É cobrado por hora ou por projeto?','Respondido','2025-08-11 08:24:54',0),(5,'Beatriz Costa','(81) 97766-554','bia.costa@emailaleatorio.com',NULL,'Tenho interesse em fazer uma parceria para fornecer materiais de construção.','Novo','2025-08-14 08:14:54',0),(6,'Alexandre Dumas','(41) 96655-443','alex.dumas@emailaleatorio.com',NULL,'Qual o valor médio para instalação de um ponto de ar condicionado?','Lido','2025-08-14 00:24:54',0),(7,'Cláudio Rocha','(62) 95544-332','claudio.r@emailaleatorio.com',NULL,'O serviço de limpeza pós-obra inclui a remoção de entulho?','Respondido','2025-08-10 08:24:54',0),(8,'Vanessa Moraes','(92) 94433-221','vanessa.m@emailaleatorio.com',NULL,'Gostaria de um orçamento para fazer um forro de gesso na sala.','Novo','2025-08-14 07:59:54',1),(9,'Tiago Nunes','(71) 93322-110','tiago.nunes@emailaleatorio.com',NULL,'Vocês atendem na região metropolitana?','Respondido','2025-08-09 08:24:54',0),(10,'Sandra Menezes','(85) 92211-009','sandra.m@emailaleatorio.com',NULL,'Preciso trocar o piso da minha loja. Vocês trabalham com porcelanato líquido?','Lido','2025-08-13 08:24:54',0),(11,'Lucas Gabriel','(11) 91122-334','lucas.g@emailaleatorio.com',NULL,'Sou arquiteto e gostaria de discutir uma possível parceria.','Novo','2025-08-14 07:24:54',1),(12,'Helena Borges','(21) 94455-667','helena.b@emailaleatorio.com',NULL,'Quanto tempo leva em média para fabricar e instalar um portão de garagem?','Respondido','2025-08-08 08:24:54',0),(13,'Igor Santana','(31) 97788-990','igor.s@emailaleatorio.com',NULL,'Obrigado pelo rápido retorno!','Lido','2025-08-12 08:24:54',0),(14,'Yasmin Furtado','(51) 90011-223','yasmin.f@emailaleatorio.com',NULL,'Preciso de um marceneiro para um pequeno reparo em um armário. Vocês fazem?','Novo','2025-08-14 07:54:54',0),(15,'Felipe Arruda','(81) 93344-556','felipe.a@emailaleatorio.com',NULL,'Qual a garantia oferecida para o serviço de impermeabilização de laje?','Respondido','2025-08-07 08:24:54',0),(16,'Laura Bernardes','(41) 96677-889','laura.b@emailaleatorio.com',NULL,'Obrigada pelo contato.','Lido','2025-08-13 08:24:54',0),(17,'Caio Martins','(62) 99900-112','caio.m@emailaleatorio.com',NULL,'Gostaria de agendar uma visita técnica para um orçamento de reforma geral.','Novo','2025-08-14 08:19:54',0),(18,'Eduarda Teixeira','(92) 92233-445','duda.t@emailaleatorio.com',NULL,'Vocês instalam câmeras de segurança?','Respondido','2025-08-06 08:24:54',0),(19,'Breno Lacerda','(71) 95566-778','breno.l@emailaleatorio.com',NULL,'O site de vocês é muito bom, parabéns!','Lido','2025-08-12 08:24:54',0),(20,'Alice Monteiro','(85) 98899-001','alice.m@emailaleatorio.com',NULL,'Preciso de um profissional para montar um telhado de madeira. Poderiam me ajudar?','Novo','2025-08-14 06:24:54',1),(21,'ariane rosa',NULL,'ariane@rosa.com',NULL,'teste teste','Novo','2026-02-19 21:22:39',1);
/*!40000 ALTER TABLE `tbl_contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_endereco`
--

DROP TABLE IF EXISTS `tbl_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_endereco` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `cep_endereco` char(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logradouro_endereco` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero_endereco` char(6) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complemento_endereco` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro_endereco` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade_endereco` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uf_endereco` char(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tbl_endereco_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_endereco`
--

LOCK TABLES `tbl_endereco` WRITE;
/*!40000 ALTER TABLE `tbl_endereco` DISABLE KEYS */;
INSERT INTO `tbl_endereco` VALUES (1,'01311-000','Avenida Paulista','500','Apto 81','Bela Vista','São Paulo','SP',1),(2,'22050-002','Avenida Atlântica','1702','Apto 1105','Copacabana','Rio de Janeiro','RJ',2),(3,'30130-141','Rua Sergipe','1440','Sala 302','Savassi','Belo Horizonte','MG',3),(4,'70340-905','SCS Quadra 7','100','Bloco A, Loja 15','Asa Sul','Brasília','DF',4),(5,'40015-010','Avenida da França','393',NULL,'Comércio','Salvador','BA',5),(6,'80420-010','Rua Comendador Araújo','731','6º andar','Batel','Curitiba','PR',6),(7,'51020-000','Avenida Conselheiro Aguiar','2333','Apto 1504','Boa Viagem','Recife','PE',7),(8,'90010-230','Rua dos Andradas','1234','Sobreloja','Centro Histórico','Porto Alegre','RS',8),(9,'60165-121','Avenida Beira Mar','3821','Apto 901','Meireles','Fortaleza','CE',9),(10,'69057-025','Avenida Djalma Batista','1661','Sala 508 - Millenium Shopping','Chapada','Manaus','AM',10),(11,'13025-151','Rua Coronel Quirino','1111','Casa','Cambuí','Campinas','SP',11),(12,'29055-420','Rua Aleixo Netto','1204','Apto 202','Praia do Canto','Vitória','ES',12),(13,'74120-020','Avenida T-4','619','Quadra 12, Lote 03','Setor Bueno','Goiânia','GO',13),(14,'65077-635','Avenida dos Holandeses','100',NULL,'Ponta do Farol','São Luís','MA',14),(15,'58038-102','Avenida General Edson Ramalho','1578','Apto 503','Manaíra','João Pessoa','PB',15),(16,'04543-011','Avenida Brigadeiro Faria Lima','4221','Galpão 2','Itaim Bibi','São Paulo','SP',16),(17,'20031-050','Avenida Presidente Wilson','231','Andar 18','Centro','Rio de Janeiro','RJ',17),(18,'30180-100','Rua dos Timbiras','2352','Casa','Barro Preto','Belo Horizonte','MG',18),(19,'41820-021','Avenida Tancredo Neves','3133','Ed. CEO Salvador Shopping, Sala 904','Caminho das Árvores','Salvador','BA',19),(20,'05425-070','Rua Butantã','123','Endereço da Obra','Pinheiros','São Paulo','SP',1);
/*!40000 ALTER TABLE `tbl_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_agendamento`
--

DROP TABLE IF EXISTS `tbl_item_agendamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_item_agendamento` (
  `id_item_agendamento` int NOT NULL AUTO_INCREMENT,
  `id_agendamento` int DEFAULT NULL,
  `id_servico` int DEFAULT NULL,
  `valor_servico` decimal(10,2) DEFAULT NULL,
  `qtde_solicitada` decimal(6,2) DEFAULT NULL,
  `total_item` decimal(10,2) DEFAULT NULL,
  `id_responsavel` int DEFAULT NULL,
  PRIMARY KEY (`id_item_agendamento`),
  KEY `id_agendamento` (`id_agendamento`),
  KEY `id_servico` (`id_servico`),
  KEY `id_responsavel` (`id_responsavel`),
  CONSTRAINT `tbl_item_agendamento_ibfk_1` FOREIGN KEY (`id_agendamento`) REFERENCES `tbl_agendamento` (`id_agendamento`),
  CONSTRAINT `tbl_item_agendamento_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `tbl_servico` (`id_servico`),
  CONSTRAINT `tbl_item_agendamento_ibfk_3` FOREIGN KEY (`id_responsavel`) REFERENCES `tbl_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_agendamento`
--

LOCK TABLES `tbl_item_agendamento` WRITE;
/*!40000 ALTER TABLE `tbl_item_agendamento` DISABLE KEYS */;
INSERT INTO `tbl_item_agendamento` VALUES (1,1,20,250.00,1.00,250.00,16),(2,2,3,150.00,1.00,150.00,17),(3,2,16,80.00,1.00,80.00,17),(4,3,2,35.50,1.00,35.50,18),(5,4,4,90.00,2.00,180.00,19),(6,6,1,120.00,1.00,120.00,16),(7,7,3,150.00,3.00,450.00,17),(8,8,2,35.50,10.00,355.00,18),(9,9,4,90.00,1.00,90.00,19),(10,10,6,180.00,1.00,180.00,16),(11,11,15,45.00,50.00,2250.00,18),(12,12,19,40.00,15.00,600.00,16),(13,14,15,70.00,8.00,560.00,20),(14,16,4,90.00,2.00,180.00,19),(15,17,3,180.00,1.00,180.00,17),(16,18,8,95.00,1.00,95.00,16),(17,20,13,75.00,1.00,75.00,20),(18,1,1,120.00,1.00,120.00,16),(19,4,4,90.00,1.00,90.00,19),(20,7,16,80.00,2.00,160.00,17);
/*!40000 ALTER TABLE `tbl_item_agendamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_item_orcamento`
--

DROP TABLE IF EXISTS `tbl_item_orcamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_item_orcamento` (
  `id_item_orcamento` int NOT NULL AUTO_INCREMENT,
  `id_orcamento` int DEFAULT NULL,
  `id_servico` int DEFAULT NULL,
  `descricao_item_orcamento` text COLLATE utf8mb4_general_ci,
  `valor_servico` decimal(10,2) DEFAULT NULL,
  `qtde_solicitada` decimal(6,2) DEFAULT NULL,
  `total_item_orcamento` decimal(10,2) DEFAULT NULL,
  `status_item_orcamento` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_item_orcamento`),
  KEY `id_orcamento` (`id_orcamento`),
  KEY `id_servico` (`id_servico`),
  CONSTRAINT `tbl_item_orcamento_ibfk_1` FOREIGN KEY (`id_orcamento`) REFERENCES `tbl_orcamento` (`id_orcamento`),
  CONSTRAINT `tbl_item_orcamento_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `tbl_servico` (`id_servico`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_item_orcamento`
--

LOCK TABLES `tbl_item_orcamento` WRITE;
/*!40000 ALTER TABLE `tbl_item_orcamento` DISABLE KEYS */;
INSERT INTO `tbl_item_orcamento` VALUES (1,1,1,'Construção de parede de alvenaria com blocos de concreto (15m x 2m).',120.00,30.00,3600.00,'Aprovado'),(2,2,3,'Instalação de 5 novos pontos de tomada no apartamento.',150.00,5.00,750.00,'Finalizado'),(3,2,16,'Troca de 8 disjuntores no quadro de luz principal.',80.00,8.00,640.00,'Finalizado'),(4,3,2,'Pintura interna (látex) de sala e dois quartos, área total de 120m².',35.50,120.00,4260.00,'Pendente'),(5,4,4,'Visita técnica e reparo de vazamento em sifão de pia de cozinha.',90.00,2.50,225.00,'Aprovado'),(6,5,15,'Pintura de fachada predial (150m²).',45.00,150.00,6750.00,'Recusado'),(7,7,3,'Instalação de 3 pontos de tomada na sala.',150.00,3.00,450.00,'Finalizado'),(8,8,2,'Aplicação de textura em parede de 10m².',35.50,10.00,355.00,'Aprovado'),(9,11,15,'Pintura da fachada (50m²).',45.00,50.00,2250.00,'Aprovado'),(10,11,17,'Reparo em telhado, troca de 10 telhas.',200.00,1.00,200.00,'Aprovado'),(11,12,19,'Reboco de parede da área de serviço (15m²).',40.00,15.00,600.00,'Finalizado'),(12,14,15,'Serviço de demolição de parede de 8m².',70.00,8.00,560.00,'Aprovado'),(13,16,4,'Reparo de cano externo.',90.00,2.00,180.00,'Finalizado'),(14,17,3,'Instalação de chuveiro elétrico 220v.',180.00,1.00,180.00,'Finalizado'),(15,6,1,'Construção de edícula (20m² de parede).',120.00,20.00,2400.00,'Pendente'),(16,9,4,'Troca de encanamento da cozinha.',90.00,8.00,720.00,'Pendente'),(17,10,6,'Manutenção mensal de jardim.',180.00,1.00,180.00,'Pendente'),(18,18,8,'Assentamento de piso em varanda (20m²).',95.00,20.00,1900.00,'Pendente'),(19,19,2,'Lixar e pintar 4 portas de madeira.',35.50,12.00,426.00,'Recusado'),(20,1,17,'Instalação de 2 câmeras na área do muro.',180.00,2.00,360.00,'Aprovado');
/*!40000 ALTER TABLE `tbl_item_orcamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orcamento`
--

DROP TABLE IF EXISTS `tbl_orcamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_orcamento` (
  `id_orcamento` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `id_pedreiro` int DEFAULT NULL,
  `descricao_orcamento` text COLLATE utf8mb4_general_ci,
  `status_orcamento` varchar(18) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_orcamento` datetime DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `finalizado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id_orcamento`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_pedreiro` (`id_pedreiro`),
  CONSTRAINT `tbl_orcamento_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_usuario` (`id_usuario`),
  CONSTRAINT `tbl_orcamento_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`),
  CONSTRAINT `tbl_orcamento_ibfk_3` FOREIGN KEY (`id_pedreiro`) REFERENCES `tbl_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orcamento`
--

LOCK TABLES `tbl_orcamento` WRITE;
/*!40000 ALTER TABLE `tbl_orcamento` DISABLE KEYS */;
INSERT INTO `tbl_orcamento` VALUES (1,1,1,16,'Orçamento para construção de muro no fundo do terreno.','Aprovado','2025-06-10 00:00:00',NULL,NULL),(2,1,1,17,'Solicitação de orçamento para troca de fiação de apartamento.','Finalizado','2025-05-20 00:00:00',NULL,'2025-06-05 00:00:00'),(3,3,1,18,'Pintura completa de sala e dois quartos.','Em Aberto','2025-08-10 00:00:00',NULL,NULL),(4,4,1,19,'Verificação e reparo de vazamento no banheiro social.','Aprovado','2025-07-15 00:00:00',NULL,NULL),(5,5,3,20,'Orçamento para reforma geral de fachada.','Recusado','2025-07-01 00:00:00',NULL,'2025-07-05 00:00:00'),(6,6,3,16,'Construção de uma pequena edícula nos fundos.','Em Aberto','2025-08-11 00:00:00',NULL,NULL),(7,7,3,17,'Instalação de 3 pontos de tomada e um ventilador de teto.','Finalizado','2025-06-25 00:00:00',NULL,'2025-07-10 00:00:00'),(8,8,3,18,'Orçamento para aplicação de textura em parede da sala.','Aprovado','2025-08-01 00:00:00',NULL,NULL),(9,9,3,19,'Troca de todo o encanamento da cozinha.','Em Aberto','2025-08-09 00:00:00',NULL,NULL),(10,10,3,3,'Orçamento para serviço de jardinagem mensal.','Em Aberto','2025-08-12 00:00:00',NULL,NULL),(11,1,6,18,'Pintura da fachada do endereço da obra.','Aprovado','2025-07-22 00:00:00',NULL,NULL),(12,12,6,16,'Reboco e acabamento de área de serviço.','Finalizado','2025-04-10 00:00:00',NULL,'2025-04-25 00:00:00'),(13,13,6,17,'Orçamento para revisão completa do quadro de luz.','Recusado','2025-05-30 00:00:00',NULL,'2025-06-02 00:00:00'),(14,14,6,20,'Orçamento para demolição de parede entre sala e cozinha.','Aprovado','2025-08-05 00:00:00',NULL,NULL),(15,15,6,3,'Solicitação de visita para orçamento de impermeabilização.','Em Aberto','2025-08-11 00:00:00',NULL,NULL),(16,3,6,19,'Conserto de cano com vazamento na área externa.','Finalizado','2025-07-18 00:00:00',NULL,'2025-07-20 00:00:00'),(17,5,6,17,'Instalação de chuveiro elétrico 220v.','Finalizado','2025-08-02 00:00:00',NULL,'2025-08-03 00:00:00'),(18,7,6,16,'Orçamento para assentar piso em varanda de 20m².','Em Aberto','2025-08-12 00:00:00',NULL,NULL),(19,9,6,18,'Orçamento para lixar e pintar portas e janelas.','Recusado','2025-06-15 00:00:00',NULL,'2025-06-18 00:00:00'),(20,11,6,3,'Solicitação de orçamento para marcenaria.','Em Aberto','2025-08-08 00:00:00',NULL,NULL);
/*!40000 ALTER TABLE `tbl_orcamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pagamento`
--

DROP TABLE IF EXISTS `tbl_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_pagamento` (
  `id_pagamento` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `total_devedor` decimal(10,2) DEFAULT NULL,
  `dinheiro` decimal(10,2) DEFAULT NULL,
  `credito` decimal(10,2) DEFAULT NULL,
  `debito` decimal(10,2) DEFAULT NULL,
  `pix` decimal(10,2) DEFAULT NULL,
  `status_pagamento` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_pagamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pagamento`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `tbl_pagamento_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pagamento`
--

LOCK TABLES `tbl_pagamento` WRITE;
/*!40000 ALTER TABLE `tbl_pagamento` DISABLE KEYS */;
INSERT INTO `tbl_pagamento` VALUES (1,2,1500.00,0.00,1500.00,NULL,0.00,'Quitado','2025-06-05 00:00:00'),(2,1,3500.00,1750.00,0.00,NULL,0.00,'Pendente','2025-06-11 00:00:00'),(3,7,850.00,0.00,0.00,NULL,850.00,'Quitado','2025-07-10 00:00:00'),(4,12,600.00,600.00,0.00,NULL,0.00,'Quitado','2025-04-25 00:00:00'),(5,3,250.00,0.00,0.00,NULL,250.00,'Quitado','2025-07-20 00:00:00'),(6,5,180.00,180.00,0.00,NULL,0.00,'Quitado','2025-08-03 00:00:00'),(7,4,400.00,0.00,0.00,NULL,200.00,'Pendente','2025-07-16 00:00:00'),(8,8,320.00,160.00,0.00,NULL,0.00,'Pendente','2025-08-02 00:00:00'),(9,1,2200.00,0.00,1100.00,NULL,0.00,'Pendente','2025-07-23 00:00:00'),(10,14,1800.00,0.00,0.00,NULL,900.00,'Pendente','2025-08-06 00:00:00'),(11,2,1500.00,0.00,750.00,NULL,0.00,'Estornado','2025-06-06 00:00:00'),(12,1,1750.00,1750.00,0.00,NULL,0.00,'Quitado','2025-08-01 00:00:00'),(13,4,200.00,0.00,200.00,NULL,0.00,'Quitado','2025-08-10 00:00:00'),(14,1,1100.00,0.00,550.00,NULL,0.00,'Pendente','2025-08-23 00:00:00'),(15,1,550.00,0.00,550.00,NULL,0.00,'Quitado','2025-09-23 00:00:00'),(16,8,160.00,0.00,0.00,NULL,160.00,'Quitado','2025-08-11 00:00:00'),(17,14,900.00,900.00,0.00,NULL,0.00,'Quitado','2025-08-12 00:00:00'),(18,1,100.00,0.00,0.00,NULL,100.00,'Estornado','2025-06-12 00:00:00'),(19,5,80.00,0.00,0.00,NULL,80.00,'Quitado','2025-07-02 00:00:00'),(20,13,120.00,120.00,0.00,NULL,0.00,'Quitado','2025-05-31 00:00:00');
/*!40000 ALTER TABLE `tbl_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_portfolio`
--

DROP TABLE IF EXISTS `tbl_portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_portfolio` (
  `id_portfolio` int NOT NULL AUTO_INCREMENT,
  `titulo_portfolio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_portfolio` text COLLATE utf8mb4_unicode_ci,
  `imagem_portfolio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_portfolio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_projeto` date DEFAULT NULL,
  `status_portfolio` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci DEFAULT 'ativo',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_portfolio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_portfolio`
--

LOCK TABLES `tbl_portfolio` WRITE;
/*!40000 ALTER TABLE `tbl_portfolio` DISABLE KEYS */;
INSERT INTO `tbl_portfolio` VALUES (1,'xxxxxxxxxxxxxx','cccccccccc dddddddddddddddddd','portfolio/699779f8410da5.65928057.webp','dddddddddddd','2026-02-19','ativo','2026-02-19 18:00:40','2026-02-19 18:00:40'),(2,'hhhhhhhhhh','fsssssssssssssssssss','portfolio/69977a0f0bdf47.97841541.webp','ggggggggggg','2026-02-18','ativo','2026-02-19 18:01:03','2026-02-19 18:01:03');
/*!40000 ALTER TABLE `tbl_portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_servico`
--

DROP TABLE IF EXISTS `tbl_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_servico` (
  `id_servico` int NOT NULL AUTO_INCREMENT,
  `nome_servico` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descricao_servico` text COLLATE utf8mb4_general_ci,
  `valor_base_servico` decimal(10,2) DEFAULT NULL,
  `foto_servico` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `status_servico` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `tipo_servico` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_servico`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `tbl_servico_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_servico`
--

LOCK TABLES `tbl_servico` WRITE;
/*!40000 ALTER TABLE `tbl_servico` DISABLE KEYS */;
INSERT INTO `tbl_servico` VALUES (1,'Construção','Levantamento de paredes de alvenaria com tijolos cerâmicos ou blocos de concreto. Valor por m².',120.00,'servicos/697cb0b0b830b9.90316294.jpg',1,'ativo','2025-08-14 08:24:59','2026-01-30 10:22:56','site'),(2,'Pintura In','Aplicação de 2 demãos de tinta látex em paredes internas. Material não incluso. Valor por m².',NULL,'servicos/699773bc548f28.68892880.webp',2,'ativo','2025-08-14 08:24:59','2026-02-19 17:34:04','site'),(3,'Instalação','Instalação de novo ponto de tomada 110v ou 220v, incluindo passagem de fiação. Valor por ponto.',150.00,'servicos/697cb0d48f8533.85411704.jpg',3,'ativo','2025-08-14 08:24:59','2026-01-30 10:23:32','site'),(4,'Reparo de ','Identificação e conserto de vazamentos simples em pias, chuveiros e vasos sanitários. Valor por hora técnica.',90.00,'servicos/697cb0dc84cb05.34495385.jpg',4,'ativo','2025-08-14 08:24:59','2026-01-30 10:23:40',NULL),(5,'Instalação','Instalação completa de porta de madeira (batente, folha e ferragens).',250.00,'serv_porta.webp',5,'Inativo','2025-08-14 08:24:59',NULL,NULL),(6,'Manutenção','Corte e aparo de grama para jardins de até 50m². Inclui limpeza da área.',180.00,'serv_gramado.webp',6,'Inativo','2025-08-14 08:24:59',NULL,NULL),(7,'Forro de G','Instalação de forro de gesso (drywall) plano. Valor por m².',85.00,'serv_forro_gesso.webp',7,'Inativo','2025-08-14 08:24:59',NULL,NULL),(8,'Assentamen','Aplicação de porcelanato em pisos ou paredes. Rejunte incluso. Valor por m².',95.00,'serv_porcelanato.webp',8,'Inativo','2025-08-14 08:24:59',NULL,NULL),(9,'Impermeabi','Aplicação de manta asfáltica ou argamassa polimérica para vedação de lajes expostas. Valor por m².',110.00,'serv_impermeabilizacao.webp',9,'Inativo','2025-08-14 08:24:59',NULL,NULL),(10,'Fabricação','Criação de portão basculante ou deslizante em ferro. Modelo simples. Valor por m².',450.00,'serv_portao.webp',10,'Inativo','2025-08-14 08:24:59',NULL,NULL),(11,'Limpeza Fi','Serviço de limpeza detalhada para remoção de poeira e resíduos de cimento/tinta. Valor por m².',25.00,'serv_limpeza_obra.webp',11,'Inativo','2025-08-14 08:24:59',NULL,NULL),(12,'Instalação','Instalação de ar condicionado modelo Split de até 9000 BTUs. Material de fixação incluso.',480.00,'serv_split.webp',12,'Inativo','2025-08-14 08:24:59',NULL,NULL),(13,'Montagem d','Montagem de móveis comprados prontos (guarda-roupa, estante, etc). Valor por hora.',75.00,'serv_montagem_movel.webp',13,'Inativo','2025-08-14 08:24:59',NULL,NULL),(14,'Instalação','Instalação de box de banheiro padrão em vidro temperado.',300.00,'serv_box_vidro.webp',14,'Inativo','2025-08-14 08:24:59',NULL,NULL),(15,'Pintura Ex','Pintura de fachadas e muros com tinta acrílica. Valor por m².',45.00,'serv_pintura_externa.webp',2,'Inativo','2025-08-14 08:24:59',NULL,NULL),(16,'Troca de D','Substituição de disjuntor em quadro de energia. Valor por unidade.',80.00,'serv_disjuntor.webp',3,'Inativo','2025-08-14 08:24:59',NULL,NULL),(17,'Reparo de ','Troca de telhas quebradas e verificação de calhas. Valor da visita técnica.',200.00,'serv_reparo_telhado.webp',18,'Inativo','2025-08-14 08:24:59',NULL,NULL),(18,'Instalação','Instalação e configuração de câmera de segurança (CFTV). Valor por ponto.',180.00,'serv_camera.webp',17,'Inativo','2025-08-14 08:24:59',NULL,NULL),(19,'Reboco de ','Aplicação de massa de reboco em paredes internas ou externas para acabamento. Valor por m².',40.00,'serv_reboco.webp',1,'Inativo','2025-08-14 08:24:59',NULL,NULL),(20,'Consultori','Visita técnica para avaliação de obra, diagnóstico de problemas e orientação. Valor por hora.',250.00,'serv_consultoria.webp',20,'Inativo','2025-08-14 08:24:59',NULL,NULL),(21,'dddddddd','dffffffffffff',NULL,'servicos/6984808b014b79.66520199.webp',NULL,'Ativo','2026-02-05 08:35:39',NULL,NULL),(22,'xxxxxxxxxx','xxxxxxxxx  dddddddd',NULL,'servicos/699771ac26e1f5.92087668.png',NULL,'Inativo','2026-02-19 08:15:31','2026-02-19 17:25:16','trabalho'),(23,'xxxxxxxxxx','dddddddddddddddd',NULL,'servicos/6996f422f34226.47067485.webp',NULL,'Inativo','2026-02-19 08:29:38','2026-02-19 17:31:36','site'),(24,'xxxxxxxxxx','sssssssssssss',NULL,'servicos/6996f54f17c77.png',NULL,'Inativo','2026-02-19 08:34:39',NULL,NULL);
/*!40000 ALTER TABLE `tbl_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sobre`
--

DROP TABLE IF EXISTS `tbl_sobre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_sobre` (
  `id_sobre` int NOT NULL AUTO_INCREMENT,
  `titulo_sobre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_sobre` text COLLATE utf8mb4_unicode_ci,
  `imagem_sobre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `missao_sobre` text COLLATE utf8mb4_unicode_ci,
  `visao_sobre` text COLLATE utf8mb4_unicode_ci,
  `valores_sobre` text COLLATE utf8mb4_unicode_ci,
  `status_sobre` enum('ativo','inativo') COLLATE utf8mb4_unicode_ci DEFAULT 'ativo',
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sobre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sobre`
--

LOCK TABLES `tbl_sobre` WRITE;
/*!40000 ALTER TABLE `tbl_sobre` DISABLE KEYS */;
INSERT INTO `tbl_sobre` VALUES (1,'xxxxxxxxxxxxx','sssssssssssssssssss','sobre/69977987e62ac3.72114507.webp','ssssssss','xxxxxxxxx','ssssssssssss','ativo','2026-02-19 17:51:56','2026-02-19 17:58:47');
/*!40000 ALTER TABLE `tbl_sobre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario`
--

DROP TABLE IF EXISTS `tbl_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email_usuario` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `senha_usuario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_usuario` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `excluido_em` datetime DEFAULT NULL,
  `foto_usuario` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'Ana Clara Souza','ana.souza@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','cliente','ativo','2025-08-14 08:24:49','2026-02-19 20:42:55',NULL,NULL),(2,'Bruno Costa XXXXX','bruno.costa@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','pedreiro','ativo','2025-08-14 08:24:49','2026-02-19 20:27:50','2026-01-30 16:03:35',NULL),(3,'Carla Dias Martins','carla.martins@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(4,'Daniel Ferreira Lima','daniel.lima@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,'2026-01-30 16:03:42',NULL),(5,'Eduarda Pereira Alves','eduarda.alves@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(6,'Fábio Gomes Ribeiro','fabio.ribeiro@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(7,'Gabriela Santos Rodrigues','gabriela.santos@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(8,'Heitor Azevedo Barros','heitor.barros@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(9,'Isabela Correia Cunha','isabela.cunha@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(10,'João Mendes Nunes','joao.nunes@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(11,'Larissa Ramos Castro','larissa.castro@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','inativo','2025-08-14 08:24:49',NULL,'2026-02-19 12:27:24',NULL),(12,'Marcelo Pinto Soares','marcelo.soares@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(13,'Natália Rocha Melo','natalia.melo@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(14,'Otávio Teixeira Sales','otavio.sales@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(15,'Patrícia Viana Farias','patricia.farias@emailcliente.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Cliente','pendente','2025-08-14 08:24:49',NULL,NULL,NULL),(16,'Ricardo Almeida Silva','ricardo.almeida@emailpro.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Pedreiro','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(17,'Sérgio Barbosa Moraes','sergio.moraes@emailpro.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Eletricista','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(18,'Tatiane Jesus Dantas','tatiane.dantas@emailpro.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Pintor','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(19,'Vinícius Nogueira Campos','vinicius.campos@emailpro.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Encanador','ativo','2025-08-14 08:24:49',NULL,NULL,NULL),(20,'William Freitas Reis','william.reis@emailpro.com','$2a$12$zP.g3o3.y2iV2R.3Q2qBgeu0Qh.3k4a5s6t7u8v9w0x1y2z3','Pedreiro','inativo','2025-08-14 08:24:49',NULL,NULL,NULL),(21,'rfaustino007@gmail.com','rfaustino007@gmail.com','$2y$10$O1jZnngGwzr53EgFq/SW/eq2ViGHeFvyI2BHQqXtgpJ3FQzbB./HS','admin','Ativo',NULL,NULL,NULL,'null'),(22,'xxxxxx','xxxxxxxx@xxxx.com','$2y$10$A0ob9cQBTeuJgFdI51VUge.64SiGNJgzDTCJ53uvNDHwY6d2QvGtC','user','1',NULL,NULL,NULL,''),(23,'rodrigo','rodrigo@faustino.com','$2y$10$Q8/wfrPel9u3Xa92xfFTqesP5G8MnQgnCQBBCxDycbZycEb1YJ68.','user','1',NULL,NULL,NULL,''),(480,'xxxxxxxxx','xxxxxxxxxx@gg.com','$2y$10$SIulcgJmlF2W/NyfVMp8iOgn.MRXThfEiZGYoslJMY3/DnEF3vGeq','user','1',NULL,NULL,NULL,''),(1123,'ssssssss','sssssssss@dd.com','$2y$10$0jOQl.6cjt9qpXXrQe5mtOFwHoL/GD9HN7Q/XFftWUCqbxIbPwJ9K','user','1',NULL,NULL,NULL,''),(1162,'ssssssssssss','sssssssSAAss@DD.COM','$2y$10$WHcGCChDIc.gNKsb8Ay.l.YFmpLUK4QdTYT0bVbep4gwz63YHUpmC','usuario','Ativo',NULL,NULL,NULL,NULL),(1179,'rodrigo','ro@faustino.com','$2y$10$fRcIe1L9mtdzylvvIQMCDens04hwGnbra93GJfXQOpYV5tEqQN3Tu','user','1',NULL,NULL,NULL,'');
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-19 21:33:20
