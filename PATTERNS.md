## Patterns

```php
# a?      Zero or one of a
# a*      Zero or more of a
# a+      One or more of a
# a{3}    Exactly 3 of a
# a{3,}   3 or more of a
# a{3,6}  Between 3 and 6 of a

# The whole thing requires each block on a new line
# In addtion there needs to be a stray new line at the end
# This is needed to make negative lookaheads work as inteded
# The \Z will still work even if there is a stray new line at the end

# Maybe useful at some point?
(?(DEFINE)(?<uuid>.{36}))
(?P>uuid)

# Generic block pattern
^(?<start>\^*)\((?<tokens>.+)\)(?<quantifier>(?:{(?:\d+,?\d*)}|\*|\+|\?)?)(?<end>\$*)$

# Generic lookbehind
^(?<direction>(?:<|<!){1})(?<start>\^*)\((?<tokens>.+)\)(?<quantifier>(?:{\d+}|\*|\+|\?)?)(?<end>\$*)$

# Generic lookahead
^(?<direction>(?:>|>!){1})(?<start>\^*)\((?<tokens>.+)\)(?<quantifier>(?:{(?:\d+,?\d*)}|\*|\+|\?)?)(?<end>\$*)$

# Generic lookahead or lookbehind
# (?<direction>(?:>|>!|<|<!)?)

# Generic lookahead and block pattern
# ^(?<direction>(?:>|>!)?)(?<start>\^*)\((?<tokens>.+)\)(?<quantifier>(?:{(?:\d+,?\d*)}|\*|\+|\?)?)(?<end>\$*)$

# --------------------

# [T] Positive block token
(?:heading)
(?:heading|label)

# [T] Negative block token
(?!heading\b).*
(?!heading\b|label\b).*

# [J] Generic JSON postive lookahead token
(?=.*"type":(?:"h2")[,}])
(?=.*"type":(?:"h2|h3")[,}])
(?=.*"type":(?:"h[123]|h4")[,}])

# [J] Generic JSON negative lookahead token
(?!.*"weight":(?:"bold")[,}])

# [J] Chained JSON tokens
(?!.*"weight":(?:"bold")[,}])(?:.*"type":(?="h2")[,}])

# Chainable block pattern using multiline flag
[S]^(?<name>(?:[V]\b(?:.{36})[D].*\n)[Q])[E]
[S]^((?:[V]\b(?:.{36})[D].*\n)[C])[E]

# Positive lookahead pattern
[S](?=^(?:[V]:.{36}\n)[C])[E]

# Negative lookahead pattern
[S](?!^(?:[V]:.{36}\n)[C])[E]

# Positive lookbehind
[S](?<=^(?:[V]:.{36}\n)[C])[E]

# Negative lookbehind
[S](?<!^(?:[V]:.{36}\n)[C])[E]

# --------------------

(?<name>(?:A:.{36}\n))
(?<name>(?:A:.{36}\n){1})
(?<name>(?:A:.{36}\n|B:.{36}\n)+)
(?<name>(?:A:.{36}\n|B:.{36}\n){1,5})

# Positive lookahead
>(A)
>(A){2}
>(A|B){2}
----
(?=(?:A:.{36}\n))
(?=(?:A:.{36}\n){2})
(?=(?:A:.{36}\n|B:.{36}\n){2})

# Negative lookahead
(?!(?:A:.{36}\n)$)
(?!(?:A:.{36}\n))
(?!(?:A:.{36}\n){2})
(?!(?:A:.{36}\n|B:.{36}\n){2})

# Lookbehinds need fixed quantifiers like {36} or {2} instead of * or +

# Positive lookbehind
(?<=^(?:A:.{36}\n))
(?<=(?:A:.{36}\n))
(?<=(?:A:.{36}\n){2})
(?<=(?:A:.{36}\n|B:.{36}\n){2})

# Negative lookbehind
(?<!^(?:A:.{36}\n))
(?<!(?:A:.{36}\n))
(?<!(?:A:.{36}\n){2})
(?<!(?:A:.{36}\n|B:.{36}\n){2})

```

