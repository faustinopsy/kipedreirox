CREATE TABLE tbl_pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL, 
    valor_total DECIMAL(10, 2) NOT NULL,
    data_pedido TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status_pedido VARCHAR(50) NOT NULL DEFAULT 'Recebido'
);

CREATE TABLE tbl_pedido_itens (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL, 
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES tbl_pedidos(id_pedido)
);

CREATE TABLE tbl_produto (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    descricao_produto TEXT NULL,
    preco_produto DECIMAL(10, 2) NOT NULL,
    foto_produto VARCHAR(255) NULL,
    status_produto VARCHAR(50) NOT NULL DEFAULT 'Ativo',
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO tbl_produto (nome_produto, descricao_produto, preco_produto, foto_produto, status_produto) VALUES
('Tijolo Baiano 9 Furos', 'Tijolo cerâmico de alta qualidade para alvenaria e vedação.', 1.20, 'tijolo_baiano.jpg', 'Ativo'),
('Cimento Votoran Todas as Obras 50kg', 'Cimento Portland composto, ideal para rebocos, contrapisos e lajes.', 28.50, 'cimento_votoran.jpg', 'Ativo'),
('Areia Média Ensacada 20kg', 'Areia lavada de granulometria média, para produção de concreto e argamassa.', 5.80, 'areia_media.jpg', 'Ativo'),
('Argamassa ACIII Quartzolit 20kg', 'Argamassa colante para assentamento de cerâmicas em áreas internas e externas.', 22.90, 'argamassa_aciii.jpg', 'Ativo'),
('Tábua de Pinus 30cm x 3m', 'Tábua de madeira tratada para uso em caixarias e andaimes.', 35.00, 'tabua_pinus.jpg', 'Inativo'); -- Este não deve aparecer no site público





-- Tabela de Gêneros (Ex: Ficção, Rock, Ação, Notícias)
CREATE TABLE `tbl_generos` (
  `id_genero` INT AUTO_INCREMENT PRIMARY KEY,
  `nome_genero` VARCHAR(100) NOT NULL UNIQUE,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  `excluido_em` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Categorias (Ex: Livro Usado, CD Raro, Lançamento)
CREATE TABLE `tbl_categorias` (
  `id_categoria` INT AUTO_INCREMENT PRIMARY KEY,
  `nome_categoria` VARCHAR(100) NOT NULL UNIQUE,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  `excluido_em` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Autores (Pode ser um escritor, banda, diretor, etc.)
CREATE TABLE `tbl_autores` (
  `id_autor` INT AUTO_INCREMENT PRIMARY KEY,
  `nome_autor` VARCHAR(255) NOT NULL,
  `biografia` TEXT NULL,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  `excluido_em` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela Principal de Itens (STI - Single Table Inheritance)
CREATE TABLE `tbl_itens` (
  `id_item` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo_item` VARCHAR(255) NOT NULL,
  `tipo_item` ENUM('livro', 'cd', 'dvd', 'revista') NOT NULL,
  `id_genero` INT NOT NULL,
  `id_categoria` INT NOT NULL,
  `descricao` TEXT NULL,
  `ano_publicacao` INT(4) NULL,
  `editora_gravadora` VARCHAR(150) NULL,
  `estoque` INT DEFAULT 1,
  
  -- Campos específicos (nullable)
  `isbn` VARCHAR(13) NULL, -- Específico para 'livro'
  `duracao_minutos` INT NULL, -- Específico para 'cd' / 'dvd'
  `numero_edicao` INT NULL, -- Específico para 'revista'

  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  `excluido_em` TIMESTAMP NULL DEFAULT NULL,

  FOREIGN KEY (`id_genero`) REFERENCES `tbl_generos`(`id_genero`),
  FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categorias`(`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela Pivot (Junção) para Itens e Autores (Relacionamento N:N)
CREATE TABLE `tbl_item_autores` (
  `id_item_autor` INT AUTO_INCREMENT PRIMARY KEY,
  `id_item` INT NOT NULL,
  `id_autor` INT NOT NULL,
  UNIQUE KEY `item_autor_unico` (`id_item`, `id_autor`), -- Evita duplicatas
  FOREIGN KEY (`id_item`) REFERENCES `tbl_itens`(`id_item`) ON DELETE CASCADE,
  FOREIGN KEY (`id_autor`) REFERENCES `tbl_autores`(`id_autor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- Gêneros
INSERT INTO `tbl_generos` (`nome_genero`) VALUES
('Ficção Científica'), ('Fantasia'), ('Romance'), ('Técnico'),
('Rock'), ('MPB'), ('Pop'), ('Clássico'),
('Ação'), ('Comédia'), ('Documentário'), ('Drama'),
('Notícias'), ('Moda'), ('Esportes'), ('Viagem');

-- Categorias
INSERT INTO `tbl_categorias` (`nome_categoria`) VALUES
('Livro Usado'), ('Livro Novo'), ('Livro Raro'),
('CD Usado'), ('CD Novo'), ('CD Importado'),
('DVD Usado'), ('DVD Novo'), ('DVD Blu-ray'),
('Revista Semanal'), ('Revista Mensal'), ('Revista Antiga');

-- Autores (Escritores, Bandas, Diretores, Editoras)
INSERT INTO `tbl_autores` (`nome_autor`) VALUES
('Isaac Asimov'), ('J.R.R. Tolkien'), ('Clarice Lispector'), ('O''Reilly Media'),
('Pink Floyd'), ('Legião Urbana'), ('Michael Jackson'), ('Beethoven'),
('Quentin Tarantino'), ('Irmãos Coen'), ('Discovery Channel'), ('Martin Scorsese'),
('Editora Abril'), ('Condé Nast'), ('ESPN Brasil'), ('National Geographic');

-- Itens: 10 Livros
INSERT INTO `tbl_itens` (`titulo_item`, `tipo_item`, `id_genero`, `id_categoria`, `ano_publicacao`, `editora_gravadora`, `isbn`) VALUES
('Fundação', 'livro', 1, 1, 1951, 'Aleph', '9788576572721'),
('O Senhor dos Anéis: A Sociedade do Anel', 'livro', 2, 2, 1954, 'HarperCollins', '9788595084759'),
('A Hora da Estrela', 'livro', 3, 3, 1977, 'Rocco', '9788532507147'),
('Learning PHP 8', 'livro', 4, 2, 2021, 'O''Reilly', '9781492093806'),
('Duna', 'livro', 1, 1, 1965, 'Aleph', '9788576572974'),
('O Hobbit', 'livro', 2, 1, 1937, 'HarperCollins', '9788595084742'),
('Perto do Coração Selvagem', 'livro', 3, 3, 1943, 'Rocco', '9788532523239'),
('SQL Antipatterns', 'livro', 4, 2, 2010, 'Pragmatic Bookshelf', '9781934356555'),
('Neuromancer', 'livro', 1, 1, 1984, 'Aleph', '9788576572943'),
('O Silmarillion', 'livro', 2, 2, 1977, 'HarperCollins', '9788595084377');

-- Itens: 10 CDs
INSERT INTO `tbl_itens` (`titulo_item`, `tipo_item`, `id_genero`, `id_categoria`, `ano_publicacao`, `editora_gravadora`, `duracao_minutos`) VALUES
('The Dark Side of the Moon', 'cd', 5, 4, 1973, 'EMI', 43),
('Dois', 'cd', 6, 4, 1986, 'EMI', 47),
('Thriller', 'cd', 7, 5, 1982, 'Epic Records', 42),
('Symphony No. 9', 'cd', 8, 6, 1824, 'Deutsche Grammophon', 70),
('Wish You Were Here', 'cd', 5, 4, 1975, 'Columbia', 44),
('Que País É Este', 'cd', 6, 5, 1987, 'EMI', 36),
('Bad', 'cd', 7, 4, 1987, 'Epic Records', 48),
('Symphony No. 5', 'cd', 8, 6, 1808, 'Decca', 35),
('The Wall', 'cd', 5, 4, 1979, 'Columbia', 81),
('As Quatro Estações', 'cd', 6, 4, 1989, 'EMI', 40);

-- Itens: 10 DVDs
INSERT INTO `tbl_itens` (`titulo_item`, `tipo_item`, `id_genero`, `id_categoria`, `ano_publicacao`, `editora_gravadora`, `duracao_minutos`) VALUES
('Pulp Fiction', 'dvd', 9, 7, 1994, 'Miramax', 154),
('Onde os Fracos Não Têm Vez', 'dvd', 12, 8, 2007, 'Miramax', 122),
('Planeta Terra', 'dvd', 11, 9, 2006, 'BBC', 550),
('Os Bons Companheiros', 'dvd', 12, 7, 1990, 'Warner Bros.', 146),
('Kill Bill: Volume 1', 'dvd', 9, 7, 2003, 'Miramax', 111),
('Fargo', 'dvd', 10, 8, 1996, 'PolyGram', 98),
('Vida Selvagem', 'dvd', 11, 9, 2011, 'Discovery', 300),
('O Irlandês', 'dvd', 12, 8, 2019, 'Netflix', 209),
('Cães de Aluguel', 'dvd', 9, 7, 1992, 'Miramax', 99),
('O Grande Lebowski', 'dvd', 10, 7, 1998, 'PolyGram', 117);

-- Itens: 10 Revistas
INSERT INTO `tbl_itens` (`titulo_item`, `tipo_item`, `id_genero`, `id_categoria`, `ano_publicacao`, `editora_gravadora`, `numero_edicao`) VALUES
('Veja - Edição Semanal', 'revista', 13, 10, 2025, 'Abril', 2950),
('Vogue Brasil', 'revista', 14, 11, 2025, 'Condé Nast', 540),
('Placar', 'revista', 15, 11, 2025, 'Abril', 1490),
('National Geographic Brasil', 'revista', 16, 11, 2025, 'Editora Z', 290),
('Superinteressante', 'revista', 13, 11, 2025, 'Abril', 460),
('Elle Brasil', 'revista', 14, 11, 2025, 'Editora Papel', 390),
('ESPN Magazine', 'revista', 15, 11, 2025, 'ESPN', 150),
('Volta ao Mundo', 'revista', 16, 11, 2025, 'Editora Globo', 220),
('Quatro Rodas', 'revista', 13, 11, 2025, 'Abril', 750),
('Casa Vogue', 'revista', 14, 11, 2025, 'Condé Nast', 430);

-- Relacionamentos (Item <-> Autor)
-- Livros
INSERT INTO `tbl_item_autores` (id_item, id_autor) VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 1), (6, 2), (7, 3), (8, 4), (9, 1), (10, 2);
-- CDs
INSERT INTO `tbl_item_autores` (id_item, id_autor) VALUES
(11, 5), (12, 6), (13, 7), (14, 8), (15, 5), (16, 6), (17, 7), (18, 8), (19, 5), (20, 6);
-- DVDs
INSERT INTO `tbl_item_autores` (id_item, id_autor) VALUES
(21, 9), (22, 10), (23, 11), (24, 12), (25, 9), (26, 10), (27, 11), (28, 12), (29, 9), (30, 10);
-- Revistas
INSERT INTO `tbl_item_autores` (id_item, id_autor) VALUES
(31, 13), (32, 14), (33, 13), (34, 16), (35, 13), (36, 14), (37, 15), (38, 16), (39, 13), (40, 14);