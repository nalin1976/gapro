<?



SELECT
DATEDIFF(now(),stocktransactions.dtmDate) AS NDays,
stocktransactions.intDocumentNo,
stocktransactions.intDocumentYear,
matitemlist.strItemDescription,
mainstores.strName
FROM
stocktransactions
Inner Join matitemlist ON matitemlist.intItemSerial = stocktransactions.intMatDetailId
Inner Join mainstores ON mainstores.strMainID = stocktransactions.strMainStoresID
WHERE
stocktransactions.strType =  'LeftOver'
?>