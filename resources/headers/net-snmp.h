#define FFI_SCOPE "pl.noflash.snmp-mib-parser"

// This file contains cherry-picked header information from Net-SNMP
// These headers are the only ones which the PHP side really uses (and can read)
// Be wise what you include here, since parsing them takes time (and PHP's FFI parser isn't perfect)

/*************************************************** Basic C types ****************************************************/
typedef	unsigned int u_int;
typedef	unsigned long u_long;
typedef	unsigned short u_short;
typedef	unsigned char u_char;


/************************************** net-snmp/include/net-snmp/library/oid.h ***************************************/
typedef uint8_t oid;


/***************************************** net-snmp/include/net-snmp/types.h ******************************************/
typedef union {
   long           *integer;
   u_char         *string;
   oid            *objid;
   u_char         *bitstring;
   struct counter64 *counter64;
   float          *floatVal;
   double         *doubleVal;
} netsnmp_vardata;

typedef struct variable_list {
   /** NULL for last variable */
   struct variable_list *next_variable;
   /** Object identifier of variable */
   oid            *name;
   /** number of subid's in name */
   size_t          name_length;
   /** ASN type of variable */
   u_char          type;
   /** value of variable */
    netsnmp_vardata val;
   /** the length of the value to be copied into buf */
   size_t          val_len;
   /** buffer to hold the OID */
   oid             name_loc[128]; //128 as defined in net-snmp/include/net-snmp/definitions.h
   /** 90 percentile < 40. */
   u_char          buf[40];
   /** (Opaque) hook for additional data */
   void           *data;
   /** callback to free above */
   void            (*dataFreeHook)(void *);
   int             index;
} netsnmp_variable_list;


/************************************* net-snmp/include/net-snmp/library/parse.h **************************************/
struct enum_list {
    struct enum_list *next;
    int             value;
    char           *label;
};

struct range_list {
    struct range_list *next;
    int             low, high;
};

struct index_list {
    struct index_list *next;
    char           *ilabel;
    char            isimplied;
};

struct varbind_list {
    struct varbind_list *next;
    char           *vblabel;
};

struct tree {
    struct tree    *child_list;     /* list of children of this node */
    struct tree    *next_peer;      /* Next node in list of peers */
    struct tree    *next;   /* Next node in hashed list of names */
    struct tree    *parent;
    char           *label;  /* This node's textual name */
    u_long          subid;  /* This node's integer subidentifier */
    int             modid;  /* The module containing this node */
    int             number_modules;
    int            *module_list;    /* To handle multiple modules */
    int             tc_index;       /* index into tclist (-1 if NA) */
    int             type;   /* This node's object type */
    int             access; /* This nodes access */
    int             status; /* This nodes status */
    struct enum_list *enums;        /* (optional) list of enumerated integers */
    struct range_list *ranges;
    struct index_list *indexes;
    char           *augments;
    struct varbind_list *varbinds;
    char           *hint;
    char           *units;
    int             (*printomat) (u_char **, size_t *, size_t *, int,
                                  const netsnmp_variable_list *,
                                  const struct enum_list *, const char *,
                                  const char *);
    void            (*printer) (char *, const netsnmp_variable_list *, const struct enum_list *, const char *, const char *);   /* Value printing function */
    char           *description;    /* description (a quoted string) */
    char           *reference;    /* references (a quoted string) */
    int             reported;       /* 1=report started in print_subtree... */
    char           *defaultValue;
   char	       *parseErrorString; /* Contains the error string if there are errors in parsing MIBs */
};

/******************************************* Various functions definitions ********************************************/
// net-snmp/include/net-snmp/library/snmp_api.h
void         init_snmp(const char *);
int          snmp_errno = 0; //not a function but it's a global var and Net-SNMP uses it for error reporting

// net-snmp/include/net-snmp/library/mib.h
struct tree *get_tree(const oid *, size_t, struct tree *);
struct tree *get_tree_head(void);
int          get_node(const char *, oid *, size_t *);

// net-snmp/include/net-snmp/library/default_store.h
int          netsnmp_ds_set_boolean(int storeid, int which, int value);

// net-snmp/include/net-snmp/mib_api.h
int          read_objid(const char *, oid *, size_t *);
void         print_objid(const oid * objid, size_t objidlen); // actually not used but nice for ad-hoc debugging

// net-snmp/include/net-snmp/library/parse.h
const char  *get_tc_descriptor(int);

// net-snmp/include/net-snmp/output_api.h
void        shutdown_snmp_logging(void); //TODO: handle this properly
