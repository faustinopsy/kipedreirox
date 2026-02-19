-- ============================================================
-- KIPEDREIRO – Migração: Categorização de Serviços
-- Execute este arquivo no banco `kipedreiro`
-- ============================================================

-- 1. Adiciona coluna tipo_servico em tbl_servico
--    'site'     = serviço exibido como vitrine no site público
--    'trabalho' = serviço que pode ser orçado e executado
ALTER TABLE `tbl_servico`
    ADD COLUMN `tipo_servico` ENUM('site', 'trabalho') NOT NULL DEFAULT 'trabalho'
    AFTER `id_categoria`;

-- 2. Ajusta valor_base_servico para NOT NULL com default 0
--    (previne erro ao inserir sem valor)
-- ALTER TABLE `tbl_servico` MODIFY `valor_base_servico` DECIMAL(10,2) NOT NULL DEFAULT 0.00;

-- 3. Marca os 4 primeiros serviços como 'site' (eles aparecem no site público)
UPDATE `tbl_servico` SET `tipo_servico` = 'site' WHERE `id_servico` IN (1,2,3,4);
