ALTER   PROCEDURE [dbo].[sp_certification_get_by_id]
            @certificationID BIGINT
        AS
        BEGIN
            SELECT 
                c.*, 
                i.firstName as issuerFirstName, 
                i.lastName as issuerLastName,
                i.issuerSignature as issuerSignatureBase64,
                o.name as organizationName,
                o.logo as organizationLogoBase64
            FROM certifications c
            LEFT JOIN issuer_information i ON c.issuerID = i.issuerID
            LEFT JOIN organization o ON i.organizationID = o.organizationID
            WHERE c.certificationID = @certificationID
        END